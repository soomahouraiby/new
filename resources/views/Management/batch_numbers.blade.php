@extends('layouts.master')
@section('content')

    <main >

        {{--Title--}}
        <div class=" col-lg-12 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="col-lg-4  h2  ml-4">ادارة الدفعات</h1>
            <div class="btn-toolbar col-lg-8 ">
                <form class="input-search">
                    <input class="form-control form-control-dark " name="search"  type="text" placeholder="البحث برقم المميز..." aria-label="بحث" size="30" value="{{$types->search}}">
                    <button><i class="fa fa-search"></i>  </button>
                </form>
                <div class="dropdown ">
                    <button type="button " class="btn btn-sm dropdown-toggle mr-4 ml-4 button" data-toggle="dropdown" id="btn">
                           حالة المدفوعات
                    </button>
                    <div class="dropdown-menu dropdown-menu-right bg-light">
                        <a class="dropdown-item border-bottom {{$types->type == 'all' || empty($types->type) ? 'active' : ''}} " href="{{route('batch_numbers')}}">جميع المدفوعات</a>
                        <a class="dropdown-item border-bottom {{$types->type == 'free' ? 'active' : ''}}" href="{{route('batch_numbers')}}?type=free"><i class="far fa-circle ml-2" style="font-size: 10px; color: #7D899B "></i> المجانية</a>
                        <a  class="dropdown-item border-bottom  {{$types->type == 'business' ? 'active' : ''}}" href="{{route('batch_numbers')}}?type=business"><i class="fas fa-circle ml-2" style="font-size: 10px; color: #7D899B "></i> التجارية</a>

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
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="product">الرقم المميز</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="payment">البار كود</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="product">تاريخ الإنتاج</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">تاريخ الانتهاء</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">كمية</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">السعر</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">الحالة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">نوع الشحنة</th>
                            <th class="sort pr-1 align-middle white-space-nowrap text-left" data-sort="amount">التحكم</th>
                        </tr>
                        </thead>
                        <tbody class="list" id="table-purchase-body">
                        @if(isset($batch_numbers))
                        @if(!$batch_numbers->isEmpty())
                            @foreach($batch_numbers as $bar)

                                <?php

                                if(($types->type == 'free' && $bar->shipments->expception == 1) || $types->type == 'business' && $bar->shipments->expception == 0){
                                    continue ;
                                }
                                ?>
                             <tr class="btn-reveal-trigger" {{Session::has('success') && Session::get('success')['id'] == $bar->id? 'style=" background: #bee8b8; "': ''}}>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$cont++}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->commercial_drugs->name}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->batch_num}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->barcode}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->production_date}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->expiry_date}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->quantity}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->price}}ر.ي</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->drug_drawn == '0' ? 'غير مسحوب': 'مسحوب'}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">{{$bar->shipments->expception == '1' ? 'تجارية': 'مجانية'}}</td>
                                    <td class="align-middle white-space-nowrap text-left name ">
                                        <a href="{{route('batch_numbers_edite', $bar->id)}}" type="button" class="btn btn-outline-primary btn-sm btn-block">تعديل</a>

                                        <a href="{{route('batch_numbers_delete', $bar->id)}}" type="button" class="btn btn-outline-danger btn-sm btn-block">حدف</a>

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
                                   <strong>عذرا, </strong> لا يوجد اي مدفوعة
                                  </div>
                            </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="New">
                <a class="" href="{{route('batch_numbers_add')}}">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-footer"></div>
        </div>
    </main>

@endsection
