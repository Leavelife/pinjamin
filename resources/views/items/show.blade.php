@extends('layouts.app')

@section('content')

<div class="text-center mb-4">
    <img src="{{ asset('storage/'.$item->image) }}" 
         style="width:200px; border-radius:10px;">
</div>

<h3>{{ $item->name }}</h3>
<span class="badge bg-success">{{ $item->status }}</span>

<p class="mt-3">{{ $item->description }}</p>

<div class="row mt-4">

    <div class="col-md-6 p-3" style="background:#A0D8E3; border-radius:12px;">
        <h5>Informasi Pemilik</h5>
        <p class="m-0">{{ $item->owner_name }}</p>
        <p class="m-0"><i class="bi bi-geo-alt"></i> {{ $item->location }}</p>
    </div>

    <div class="col-md-6 p-3" style
