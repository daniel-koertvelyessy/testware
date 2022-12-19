@extends('layout.layout-admin')

@section('mainSection', __('Gerät'))

@section('pagetitle')
    Update testWare
@endsection

@section('content')

    <div class="container-fluid">


        @dump($dumpSQL)
        @dump($result_sql_dump)
        <div class="bg-light p-7">
            <samp>@foreach ($result_sql_dump as $line)
                    {{ $line}}
                @endforeach</samp>
        </div>

        <h2>Update Code from git repository</h2>
        <p>Feedback from git pull:</p>
        <div class="bg-light p-7">
            <samp>@foreach ($res_git_pull as $line)
                    {{ $line}}
                @endforeach</samp>
        </div>
        <h2>Migrate DB</h2>
        <p>Feedback from migration: {{$result_migrate}}</p>
        <div class="bg-light p-7">
            <samp>{{ $response_migrate }}</samp>
        </div>
    </div>
@endsection