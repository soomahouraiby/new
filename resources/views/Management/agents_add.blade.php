@extends('layouts.master')
@section('content')

    {{--Title--}}
    <main >
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="h2  ml-4"> اضافة وكيل</h1>
            <a href="{{route('all_agents')}}"> الرجوع <i class="fa fas fa-share"></i>
                 </a>
        </div>

        <div class="card shadow mb-0 pb-0" >
            <div class="card-header " style="background-color: #F9F9F9;">
                <div class="row m-2">
                    {{-- <h4> ..... </h4> --}}
                </div>
            </div>
            <form method="post"  action="{{route('agents_insert')}}" >
                @csrf
                <div class="card-body position-relative mb-0 pb-0" style="background-color: #F9F9F9;">
                    <div class="row pb-5 ">
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label "> الاسم : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="name" type="text" required class="form-control" >
                                    @if($errors->has('name'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  البريد : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="email" type="email" class="form-control"   required  >
                                    @if($errors->has('email'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الهاتف : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="phone" type="number" class="form-control"     >
                                    @if($errors->has('phone'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('phone') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  العنوان : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="address" type="text" class="form-control"     >
                                    @if($errors->has('address'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('address') }}</small>
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


@endsection
