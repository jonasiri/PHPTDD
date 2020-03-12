@extends('layouts.app')

@section('content')
    <div class="w-2/3 bg-gray-200 mx-auto p-6 shadow">

        <form action="{{route('add-author')}}" method="POST" class="flex flex-col items-center">
            @csrf
            <h1>Add new author</h1>

            <div class="pt-4">
                <input class="rounded px-4 py-2 w-64" type="text" name="name" placeholder="Full name">
                @if($errors->has('name'))
                    <p class="text-red-600"> {{$errors->first('name')}}</p>
                @endif

            </div>

            <div class="pt-4">
                <input class="rounded px-4 py-2 w-64" type="date" name="dob" placeholder="Date of birth">
                @if($errors->has('dob'))
                <p class="text-red-600"> {{$errors->first('dob')}}</p>
            @endif
            </div>

            <div class="pt-4">
                <button class="bg-blue-400 text-white rounded py-2 px-4" type="submit">Add new Author</button>
            </div>

        </form>


    </div>
@endSection
