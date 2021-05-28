@extends('layouts.master')
@section('content')

    {{--Title--}}
    <main >
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="h2  ml-4"> اضافة دفعة</h1>
            <a href="{{route('batch_numbers')}}"> الرجوع <i class="fa fas fa-share"></i>
                 </a>
        </div>

        <div class="card shadow mb-0 pb-0" >
            <div class="card-header " style="background-color: #F9F9F9;">
                <div class="row m-2">
                    {{-- <h4> ..... </h4> --}}
                </div>
            </div>
            <form method="post"  action="{{route('batch_numbers_insert')}}" >
                @csrf
                <div class="card-body position-relative mb-0 pb-0" style="background-color: #F9F9F9;">
                    <div class="row pb-5 ">
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label "> الرقم المميز : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="batch_num" type="number" required min="1" max="20000000000" class="form-control" >
                                    @if($errors->has('batch_num'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('batch_num') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الباركود : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="barcode" type="number" class="form-control"   required min="1" max="20000000000" >
                                    @if($errors->has('barcode'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('barcode') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">   تاريخ الإنتاج : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="production_date" required type="date" class="form-control" value="" >
                                    @if($errors->has('production_date'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('production_date') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">   تاريخ الانتهاء : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="expiry_date" required type="date" class="form-control"  >
                                    @if($errors->has('expiry_date'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('expiry_date') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  كمية : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="quantity" type="number" required min="1" max="20000000000"  class="form-control" >
                                    @if($errors->has('quantity'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('quantity') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  السعر : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="price" type="text" pattern="^\d+(\.\d{1,})?$"   required min="1" max="20000000000" class="form-control"  >
                                    @if($errors->has('price'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('price') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الحالة : </label>

                                </div>
                                <div class="col-md-8">
                                    <select  class="form-control" name="drug_drawn" required>
                                        <option value="0"  > غير مسحوب</option>
                                        <option value="1">مسحوب </option>
                                    </select>
                                      @if($errors->has('drug_drawn'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('drug_drawn') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الدواء : </label>

                                </div>
                                <div class="col-md-8">
                                    <select class="form-control " required name="commercial"  id="commercial" >  </select>
                                      @if($errors->has('commercial'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('commercial') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  نوع الشحنة	 : </label>

                                </div>
                                <div class="col-md-8">
                                    <select  class="form-control" name="shipment_type" required>
                                        <option value="1"  > تجارية</option>
                                        <option value="0" >مجانية</option>
                                    </select>
                                      @if($errors->has('shipment_type'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('shipment_type') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >

                            <button class="btn  btn-primary " style=" float: left;color: ivory;" type="submit" >اضافة</button>


                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>
    <script type="text/javascript">
        window.onload = function (){
            $('#commercial').select2({
          placeholder: 'اختر دواء',
          minimumInputLength: 2,
          ajax: {
            url: "{{route('load_ajax', 'commercial_drugs')}}",
            dataType: 'json',

            processResults: function (data) {
              return {
                results: data
              };
            },
            cache: true
          }
        });
        }
  </script>

@endsection
