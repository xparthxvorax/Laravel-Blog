@extends('layouts.app')
@section('content')
<section id="blog-list">
    <div class="container">
        <div>
            <div class="page-title"><h2>All blogs</h2></div>
        </div>
        <div class="row">
            @include('flash::message')
            <div class="col-sm-9">
             @if($blogs->all())
             @foreach($blogs as $blog)
             <article>
                <h2><a href="{{ route('blog.show', $blog) }}">{{ $blog->title }}</a></h2>
                <div class="col-sm-3">
                    <img src="{{ asset(Helper::getImageThumb($blog->blog_image, 150, 150)) }}" />
                </div>
                <div class="col-sm-9">
                    <blockquote>{!! str_limit($blog->text, 700) !!}</blockquote>
                    <div class="blog-footer">
                        <div class="blog-info">
                            <p>Posted by: <em>{{ $blog->user->name or 'Anonymous' }}</em><span>on</span><em>{{ $blog->published_on }}</em></p>
                        </div>
                        <div class="blog-actions">
                            <em><a href="{{ route('blog.show', $blog) }}" class="btn btn-success">Read</a></em>
                            @can('update', $blog)
                            <em><a href="{{ route('blog.edit', $blog) }}" class="btn btn-info">Edit</a></em>
                            @endcan
                            @can('update', $blog)
                            {!! Form::open(['route' => ['blog.destroy', $blog], 'method' => 'POST', 'role' => "form"]) !!}
                            <em>{!! Form::submit('Delete', ['class' => 'btn btn-danger delete-btn']) !!}</em>
                            {{ method_field('DELETE') }}
                            {!! Form::close() !!}
                            @endcan
                        </div>
                    </div>    
                </div>
            </article>
            @endforeach
            <div class="text-center">
                <div class="pagination">
                    {!! $blogs->links() !!}
                </div>
            </div>
            @else
            <div class="text-center"><h2>No blogs to display</h2></div>
            @endif
        </div>
        <div class="sidebar col-sm-3">
            @include('tag.index')
        </div>
    </div>
</div>
</section>
@endsection