@extends('layouts.app') 
@section('content')
    <h1 class="text-center">
        {{$exam->title}}
        @can('建立測驗')
            <a href="#" class="btn btn-danger btn-del-exam" data-id="{{ $exam->id }}">刪除</a>
            <a href="{{route('exam.edit', $exam->id)}}" class="btn btn-warning">編輯</a>
        @endcan
    </h1>

    {{-- 題目表單 --}}
    @can('建立測驗')
        @include('exam.form')
    @endcan

    {{-- 題目列表 --}}
    @if(Auth::check())
        @can('進行測驗')
            {{ bs()->openForm('post', '/test') }}
                @include('exam.topic')
                {{ bs()->hidden('user_id', Auth::id()) }}
                {{ bs()->hidden('exam_id', $exam->id) }}
                <div class="text-center my-5">
                    {{ bs()->submit('寫完送出') }}
                </div>
            {{ bs()->closeForm() }}
        @else
            @include('exam.topic')
        @endcan
    @else
        <div class="alert alert-info">
            <h3 class="text-center">本測驗共有{{$exam->topics->count()}}題，需登入後始可測驗或編輯題目</h3>
        </div>
    @endif
        
    <div class="text-center">
        {{$exam->user->name}} ({{$exam->user->email}})發佈於 {{$exam->created_at->format("Y年m月d日 H:i:s")}} / 最後更新： {{$exam->updated_at->format("Y年m月d日 H:i:s")}}
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.btn-del-topic').click(function(){
                var topic_id=$(this).data('id');                
                swal({
                    title: "確定要刪除題目嗎？",
                    text: "刪除後該題目就消失救不回來囉！",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是！含淚刪除！",
                    cancelButtonText: "不...別刪",
                }).then((result) => {
                    if (result.value) {                        
                        axios.delete('/topic/' + topic_id)
                        .then(function(){
                            return swal("OK！刪掉題目惹！", "該題目已經隨風而逝了...", "success");
                        }).then(function () {
                            location.reload();
                        });
                    }
                })
            });

            // 刪除按鈕點擊事件
            $('.btn-del-exam').click(function() {
                // 獲取按鈕上 data-id 屬性的值，也就是編號
                var id = $(this).data('id');
                // 調用 sweetalert
                swal({
                    title: "確定要刪除測驗嗎？",
                    text: "刪除後該測驗連同所有題目就消失救不回來囉！",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是！含淚刪除！",
                    cancelButtonText: "不...別刪",
                }).then((result) => {
                    if (result.value) {
                        // 調用刪除介面，用 id 來拼接出請求的 url
                        axios.delete('/exam/' + id)
                        .then(function(){
                            return swal("OK！刪掉測驗惹！", "該測驗所有資料已經隨風而逝了...", "success");
                        }).then(function () {
                            location.href='/exam';
                        });
                    }
                });
            });
        });
    </script>
@endsection