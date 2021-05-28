@extends('layouts.master')
@section('content')

    {{--Title--}}
    <main >
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="h2  ml-4"> التعديل على مادة الفعالة</h1>
            <a href="{{route('all_effective_materials')}}"> الرجوع <i class="fa fas fa-share"></i>
            </a>
        </div>

        <div class="card shadow mb-0 pb-0" >
            <div class="card-header " style="background-color: #F9F9F9;">
                <div class="row m-2">
                    <h4>اسم المادة: {{$effective_material->name }} </h4>
                </div>
            </div>
            <form method="post"  action="{{route('effective_materials_update', $id)}}" >
                @csrf
                <div class="card-body position-relative mb-0 pb-0" style="background-color: #F9F9F9;">
                    <div class="row pb-5 ">
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">الاسم : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="name" type="text" required class="form-control" value="{{ !empty(old('name'))? old('name') : $effective_material->name  }}" >
                                    @if($errors->has('name'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  دواعي للاستخدام  : </label>

                                </div>
                                <div class="col-md-8">
                                    <textarea  name="indications_use"  class="form-control"   required  >{{ !empty(old('indications_use'))? old('indications_use') : $effective_material->indications_use  }}</textarea>
                                    @if($errors->has('indications_use'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('indications_use') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>


                        <div class="form-group col-lg-6 raw mt-4 " >

                            <button class="btn  btn-primary " style=" float: left;color: ivory;" type="submit" >حفظ</button>


                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>


@endsection
