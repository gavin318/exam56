@extends('layouts.app')
@section('content')
    <h1 class="text-center">{{$test->exam->title}}</h1>
    <div class="row">
        <div class="col-sm-6">
            <h3>時間：<u>{{$test->created_at->format("Y年m月d日 H:i:s")}}</u></h3>
        </div>
        <div class="col-sm-6 text-right">
            <h3><u> {{ $test->grade }} </u>年<u> {{ $test->class }} </u>班<u> {{ $test->num }} </u>號 姓名：<u>{{$test->user->name}}</u> 得分：<b class="
            @if($test->score >= 60)
                text-info
            @else
                text-danger
            @endif
            ">{{$test->score}}</b></h3>
        </div>   
    </div>
    <hr>

    
    @foreach ($content as $key => $data)
        <dl>
            <dt class="h3">            
                @if($data['ans']==$data['topic']->ans)
                    <img src="{{asset('yes.png')}}" alt="答對了！" title="答對了！">
                @else
                    <img src="{{asset('no.png')}}" alt="答錯！正確解答為「{{ $data['topic']->ans }}」" title="答錯！正確解答為「{{ $data['topic']->ans }}」">
                @endif
                {{-- {{ bs()->badge()->text($key) }} --}}
                （{{$data['ans']}}）
                <span class="badge badge-success">{{ $key }}</span>
                {{$data['topic']->topic}}
            </dt>
            
            <dd class="opt ml-5 my-2">
                {{ bs()->radioGroup("ans[{$data['topic']->id}]", [
                    1 => "&#10102; {$data['topic']->opt1}", 
                    2 => "&#10103; {$data['topic']->opt2}",  
                    3 => "&#10104; {$data['topic']->opt3}",  
                    4 => "&#10105; {$data['topic']->opt4}", 
                    ])
                    ->selectedOption($data['topic']->ans)
                    ->addRadioClass(['my-1','mx-3'])}}
            </dd>
        </dl>
    @endforeach

@endsection
