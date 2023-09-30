<x-admin-layout title="Create Category">
    <form action="{{route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form')
    </form>
</x-admin-layout>
