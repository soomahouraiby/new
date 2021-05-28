@extends('layouts.master')
@section('content')

    <main >

        {{--Title--}}
        <div class=" col-lg-12 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="col-lg-4  h2  ml-4">ادارة المواد الفعالة</h1>
            <div class="btn-toolbar col-lg-8 ">
                <form class="input-search">
                    <input class="form-control form-control-dark " name="search"  type="text" placeholder="البحث عن مادة..." aria-label="بحث" size="30" value="{{$types->search}}">
                    <button><i class="fa fa-search"></i>  </button>
                </form>
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
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="email">اسم المادة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="product">دواعي للاستخدام </th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">التحكم</th>
                        </tr>
                        </thead>
                        <tbody class="list" id="table-purchase-body">
                        @if(isset($effective_materials))
                        @if(!$effective_materials->isEmpty())
                            @foreach($effective_materials as $ef)
                             <tr class="btn-reveal-trigger" {{Session::has('success') && Session::get('success')['id'] == $ef->id? 'style=" background: #bee8b8; "': ''}}>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cont++}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$ef->name}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <button type="button" class="btn btn-outline-info btn-sm sowdata"  data-title=" دواعي للاستخدام   لـ {{$ef->name}}" data-message="{{ $ef->indications_use}}">اطلاع</button>
                                        </td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <a href="{{route('effective_materials_edite', $ef->id)}}" type="button" class="btn btn-outline-primary btn-sm btn-block">تعديل</a>

                                        <a href="{{route('effective_materials_delete', $ef->id)}}" type="button" class="btn btn-outline-danger btn-sm btn-block">حدف</a>

                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr class="btn-reveal-trigger">
                                <td class="align-middle text-left  white-space-nowrap payment" colspan="11">
                                    <div class="alert alert-danger" role="alert">
                                       <strong>عذرا, </strong> لا يوجد اي نتيجة
                                      </div>
                                </td>
                                </tr>
                            @endif
                            @else
                            <tr class="btn-reveal-trigger">
                            <td class="align-middle text-left  white-space-nowrap payment" colspan="11">
                                <div class="alert alert-danger" role="alert">
                                   <strong>عذرا, </strong> لا يوجد اي مادة فعالة
                                  </div>
                            </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="New">
                <a class="" href="{{route('effective_materials_add')}}">
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
