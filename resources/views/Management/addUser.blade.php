@extends('layouts.master')
@section('content')

    {{--Title--}}
    <main >
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="h2  ml-4"> اضافة مستخدم</h1>
        </div>

        <div class="card shadow mb-0 pb-0" >
            <div class="card-header " style="background-color: #F9F9F9;">
                <div class="row m-2">
                    <h4> ..... </h4>
                </div>
            </div>
            <form method="post">
                @csrf
                <div class="card-body position-relative mb-0 pb-0" style="background-color: #F9F9F9;">
                    <div class="row pb-5 ">
                        <div class="form-group col-lg-12 raw mt-4 " style="display: flex; flex-wrap: wrap; ">
                            <label class="col-form-label   mt-2 mx-4 "> اسم المستخدم : </label>
                            <div class=" mt-2 col-lg-6 ">
                                <input name="user_name" type="text" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group raw mt-4 col-lg-12 " style="display: flex; flex-wrap: wrap; ">
                            <label class="col-form-label   mt-2 mx-4 "> البريد الإلكتروني : </label>
                            <div class=" mt-2 col-lg-4">
                                <input name="email" type="email" class="form-control" value="" >
                            </div>
                            <label class="col-form-label   mt-2 mx-4 "> رقم الهاتف : </label>
                            <div class=" mt-2 col-lg-3">
                                <input name="phone" type="tel" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group raw mt-4 col-lg-12 " style="display: flex; flex-wrap: wrap; ">
                            <label class="col-form-label   mt-2 mx-4 "> العنوان : </label>
                            <div class=" mt-2 col-lg-8">
                                <input name="address" type="text" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group raw mt-4 col-lg-12 " style="display: flex; flex-wrap: wrap; ">
                            <label class="col-form-label   mt-2 mx-4 "> المديرية : </label>
                            <div class=" mt-2 col-lg-4">
                                <input name="district" type="text" class="form-control" value="" >
                            </div>
                            <label class="col-form-label   mt-2 mx-4 "> الصفة : </label>
                            <div class=" mt-2 col-lg-4">
                                    <select  class="form-control" name="roles[]" >
                                        <option value="المدير العام"  > المدير العام</option>
                                        <option value=" مدير العمليات" > مدير العمليات</option>
                                        <option value="مدير الصيدلة"  >مدير الصيدلة</option>
                                        <option value="مدير التيقظ الدوائي" >مدير التيقظ الدوائي</option>
                                    </select>
                            </div>

                        </div>
                        <div class="form-group raw mt-4 " style="display: flex; flex-wrap: wrap; ">
                            <div class="form-group  mt-4 " style="float: right">
                                <button class="btn " type="submit" style=" float:right;margin-right:90%; background-color: #5468FF; color:#ffffff">تعديل</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

@endsection
