@extends('layouts.app') 
@section('content')
    <h1>測驗一覽<small>（共 {{$exams->total()}} 筆資料）</small></h1>
    <div class="list-group">
        @forelse($exams as $exam)
            <a href="exam/{{ $exam->id }}" class="list-group-item list-group-item-action">{{ $exam->updated_at->format("Y年m月d日") }} - {{ $exam->title }}</a>
        @empty
            <div class="list-group">尚無任何測驗</div>
        @endforelse        
    </div>

    <div class="my-3">
        {{ $exams->links() }}
    </div>
@endsection
