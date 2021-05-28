@extends('layouts.master')
@section('content')

    <main >

        {{--Title--}}
        <div class=" col-lg-12 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="col-lg-4  h2  ml-4">ادارة الادوية</h1>
            <div class="btn-toolbar col-lg-8 ">
                <form class="input-search">
                    <input class="form-control form-control-dark " name="search"  type="text" placeholder="البحث  عن دواء..." aria-label="بحث" size="30" value="{{$types->search}}">
                    <button><i class="fa fa-search"></i>  </button>
                </form>
                <div class="dropdown ">
                    <button type="button " class="btn btn-sm dropdown-toggle mr-4 ml-4 button" data-toggle="dropdown" id="btn">
                            النوع
                    </button>
                    <div class="dropdown-menu dropdown-menu-right bg-light">
                        <a class="dropdown-item border-bottom {{ ($types->type == NULL) ? 'active' : ''}} " href="{{route('all_drugs')}}">جميع الانواع</a>
                        @foreach ($list_drug_form as $key => $form )
                        <a class="dropdown-item border-bottom {{$types->type ==  $key  && $types->type  != NULL? 'active' : ''}} " href="{{route('all_drugs')}}?type={{$key }}">{{$form }}</a>
                        @endforeach



                    </div>
                </div>

            </div>
        </div>



        {{--Content--}}
        <div class="card shadow mb-3 w-9" style=" width:calc(96% - 35px);background-color: #F9F9F9;">
            <div class="card-body px-0 py-0" style="background-color: #F9F9F9;">
                <div class="table-responsive scrollbar">
                    @if(Session::has('message'))


                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      @endif
                      @if(Session::has('success'))


                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ Session::get('success')['message'] }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      @endif
                    <table class="table table-hover fs--1 mb-0 " style="background-color: #F9F9F9;">
                        <thead class="bg-200 text-900">
                        <tr  >

                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="name">#</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="email">اسم الدواء</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="product">رقم الدواء</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="payment"> الصورة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="product"> طريقة الاستخدام</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">الاثار الجانبية </th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">نوع الدواء</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">الشركة المصنعة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount"> الوكيل</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount"> الامراض المزمنة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">  المواد الفعالة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">التحكم</th>
                        </tr>
                        </thead>
                        <tbody class="list" id="table-purchase-body">
                        @if(isset($commercial_drugs))
                        @if(!$commercial_drugs->isEmpty())
                            @foreach($commercial_drugs as $cd)

                                <?php

                                if(($types->type != NULL && $cd->drug_form != $types->type)){
                                    continue ;
                                }
                                ?>
                             <tr class="btn-reveal-trigger" {{Session::has('success') && Session::get('success')['id'] == $cd->id? 'style=" background: #bee8b8; "': ''}}>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cont++}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cd->name}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cd->register_no }}</td>
                                    <td class="align-middle white-space-nowrap text-left name "><img width="100" src="{{asset('storage/images/drugs/'.$cd->photo )}}">
                                       </td>
                                    <td class="align-middle white-space-nowrap text-left name "> <button type="button" class="btn btn-outline-info btn-sm sowdata"  data-title="طريقة الاستخدام لـ {{$cd->name}}" data-message="{{$cd->how_use}}">اطلاع</button> </td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <button type="button" class="btn btn-outline-info btn-sm sowdata"  data-title=" الاثار الجانبية  لـ {{$cd->name}}" data-message="{{$cd->side_effects}}">اطلاع</button>
                                        </td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{isset( $list_drug_form[$cd->drug_form])?  $list_drug_form[$cd->drug_form] : 'غير معروف'}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cd->companies->name}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cd->Agents->name}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <?php
                                        $data_diseases = '';
                                        foreach ($cd->diseases as  $value) {
                                            $data_diseases .=  '<li>'. $value->name . '</li>';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-outline-info btn-sm sowdata"  data-title="  الامراض المزمنة  لـ {{$cd->name}}" data-message="{{$data_diseases}}">اطلاع</button>

                                        </ul>
                                    </td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <?php
                                        $combination = '';
                                        foreach ($cd->combinations as  $value) {
                                            $combination .=  '<li>'. $value->name . '</li>';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-outline-info btn-sm sowdata"  data-title="   المواد الفعالة  لـ {{$cd->name}}" data-message="{{$combination}}">اطلاع</button>

                                        </ul>
                                    </td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <a href="{{route('drugs_edite', $cd->id)}}" type="button" class="btn btn-outline-primary btn-sm btn-block">تعديل</a>

                                        <a href="{{route('drugs_delete', $cd->id)}}" type="button" class="btn btn-outline-danger btn-sm btn-block">حدف</a>

                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr class="btn-reveal-trigger">
                                <td class="align-middle text-left  white-space-nowrap payment" colspan="12">
                                    <div class="alert alert-danger" role="alert">
                                       <strong>عذرا, </strong> لا يوجد اي نتيجة
                                      </div>
                                </td>
                                </tr>
                            @endif
                            @else
                            <tr class="btn-reveal-trigger">
                            <td class="align-middle text-left  white-space-nowrap payment" colspan="12">
                                <div class="alert alert-danger" role="alert">
                                   <strong>عذرا, </strong> لا يوجد اي دواء
                                  </div>
                            </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="New">
                <a class="" href="{{route('drugs_add')}}">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-footer"></div>
        </div>
    </main>
    <script>
        window.onload = function (){
            $(".sowdata").on("click", function(e) {
                var dialog = bootbox.dialog({
                title: $(this).data('title'),
                message: $(this).data('message').replace(/\n\r?/g, '<br />'),
                locale: 'ar'
            });

            // dialog.init(function(){
            //         dialog.find('.bootbox-body').html($(this).data('message'));
            // });
        });

        }
    </script>

@endsection
