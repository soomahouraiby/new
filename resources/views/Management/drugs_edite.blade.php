@extends('layouts.master')
@section('content')

    {{--Title--}}
    <main >
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pr-2  border-bottom main " >
            <h1 class="h2  ml-4"> تعديل على  دواء</h1>
            <a href="{{route('all_drugs')}}"> الرجوع <i class="fa fas fa-share"></i>
                 </a>
        </div>

        <div class="card shadow mb-0 pb-0" >
            <div class="card-header " style="background-color: #F9F9F9;">
                <div class="row m-2">
                    <h4> تعديل دواء : {{$drug->name}}</h4>
                </div>
            </div>
            <form   action="{{route('drugs_update', $drug->id)}}"  method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body position-relative mb-0 pb-0" style="background-color: #F9F9F9;">
                    <div class="row pb-5 ">
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الاسم : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="name" type="text" required class="form-control"  value="{{ !empty(old('name'))? old('name') : $drug->name  }}" >
                                    @if($errors->has('name'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  رقم الدواء : </label>

                                </div>
                                <div class="col-md-8">
                                    <input name="register_no" type="number" class="form-control"   required min="1" max="20000000000"  value="{{ !empty(old('register_no'))? old('register_no') : $drug->register_no  }}" >
                                    @if($errors->has('register_no'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('register_no') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  طريقة الاستخدام : </label>

                                </div>
                                <div class="col-md-8">
                                    <textarea name="how_use" required type="date" class="form-control">{{ !empty(old('how_use'))? old('how_use') : $drug->how_use  }}</textarea>
                                    @if($errors->has('how_use'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('how_use') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">   موانع الاستخدام : </label>

                                </div>
                                <div class="col-md-8">
                                    <textarea name="prevents_use" required type="date" class="form-control">{{ !empty(old('prevents_use'))? old('prevents_use') : $drug->prevents_use  }}</textarea>
                                    @if($errors->has('prevents_use'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('prevents_use') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الاثار الجانبية  : </label>

                                </div>
                                <div class="col-md-8">
                                    <textarea  name="side_effects"  required   class="form-control" >{{ !empty(old('side_effects'))? old('side_effects') : $drug->side_effects  }}</textarea>
                                    @if($errors->has('side_effects'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('side_effects') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  صورة الدواء : </label>

                                </div>
                                <div class="col-md-8">
                                    <div class="imge-file text-center" style=" position: relative; ">
                                        <input  name="photo" type="file" id="uploadFile" class="form-control" accept="image/*" style="position: absolute;clip: rect(0px, 0px, 0px, 0px);">
                                        <div id="cloc-inbot-file" class="file-img btn btn-outline-info btn-sm sowdata">أختيار صورة</div>
                                        <img id="profile_image" width="150" src="{{asset('storage/images/drugs/'.$drug->photo )}}">
                                    </div>
                                    @if($errors->has('photo'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('photo') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  النوع : </label>

                                </div>
                                <div class="col-md-8">
                                    <select  class="form-control"  name="drug_form" required>
                                        @foreach ($list_drug_form as $key => $df)

                                        <option value="{{$key}}"  {{ (old('drug_form') != NULL  &&  old('drug_form') == $key) || ( $key == $drug->drug_form)? 'selected': '' }}> {{ $df}}</option>
                                        @endforeach

                                    </select>
                                      @if($errors->has('drug_form'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('drug_form') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الشركة : </label>

                                </div>
                                <div class="col-md-8">
                                    <select class="form-control " required name="company_id"  id="company_id" >
                                        @if ($companie != NULL )
                                        <option value="{{$companie->id}}" selected>{{$companie->name}} </option>
                                       @else
                                       <option value="{{$drug->companies->id}}" selected>{{$drug->companies->name}} </option>

                                   @endif
                                    </select>
                                      @if($errors->has('company_id'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('company_id') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  الوكيل : </label>

                                </div>
                                <div class="col-md-8">
                                    <select class="form-control " required name="agent_id"  id="agent_id" >
                                        @if ($agent != NULL )
                                        <option value="{{$agent->id}}" selected>{{$agent->name}} </option>
                                       @else
                                       <option value="{{$drug->Agents->id}}" selected>{{$drug->Agents->name}} </option>

                                   @endif </select>
                                      @if($errors->has('agent_id'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('agent_id') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label ">  المواد الفعالة : </label>

                                </div>
                                <div class="col-md-8">
                                    <select class="form-control " required name="material_id[]" multiple="multiple"  id="material_id" >
                                        @if ($material != NULL )
                                            @foreach ( $material as $mat)
                                                  <option value="{{$mat->id}}" selected>{{$mat->name}} </option>
                                            @endforeach
                                       @else
                                        @foreach ( $drug->combinations as $mat)
                                                 <option value="{{$mat->id}}" selected>{{$mat->name}} </option>
                                        @endforeach

                                   @endif
                                    </select>
                                      @if($errors->has('material_id'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('material_id') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-lg-6 raw mt-4 " >
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label "> الامراض المزمنة : </label>

                                </div>
                                <div class="col-md-8">
                                    <select class="form-control " required name="diseases_id[]" multiple="multiple"  id="diseases_id" >
                                        @if ($diseases != NULL )
                                            @foreach ( $diseases as $dis)
                                                  <option value="{{$dis->id}}" selected>{{$dis->name}} </option>
                                            @endforeach
                                       @else
                                        @foreach ( $drug->diseases as $dis)
                                                 <option value="{{$dis->id}}" selected>{{$dis->name}} </option>
                                        @endforeach

                                   @endif
                                </select>
                                      @if($errors->has('agent_id'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('agent_id') }}</small>
                                    @endif
                                    </select>
                                      @if($errors->has('diseases_id'))
                                             <small style=" color: #e91e63; ">{{ $errors->first('diseases_id') }}</small>
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
    <script type="text/javascript">
        window.onload = function (){
            $('#company_id').select2({
          placeholder: 'اختر شركة',
          minimumInputLength: 2,
          ajax: {
            url: "{{route('load_ajax', 'companies')}}",
            dataType: 'json',

            processResults: function (data) {
              return {
                results: data
              };
            },
            cache: true
          }
        });



        $('#agent_id').select2({
          placeholder: 'اختر وكيل',
          minimumInputLength: 2,
          ajax: {
            url: "{{route('load_ajax', 'agents')}}",
            dataType: 'json',

            processResults: function (data) {
              return {
                results: data
              };
            },
            cache: true
          }
        });

        $('#material_id').select2({
  placeholder: 'اختر المواد الفعالة',
  minimumInputLength: 2,
  ajax: {
    url: "{{route('load_ajax', 'effective_materials')}}",
    dataType: 'json',

    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  }
});

$('#diseases_id').select2({
  placeholder: 'اختر الامراض المزمنة ',
  minimumInputLength: 2,
  ajax: {
    url: "{{route('load_ajax', 'diseases')}}",
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
  <script type="text/javascript">

    document.getElementById('uploadFile').addEventListener('change', function (){


            var myInout = this ;
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                //    myInout.parentElement.firstElementChild.style.backgroundImage =  "url("+this.result+")";
                   document.getElementById('profile_image').src = this.result;

                }
            }
        });

         document.getElementById('cloc-inbot-file').onclick = function (){
            document.getElementById('uploadFile').click();
         };



    </script>

@endsection
