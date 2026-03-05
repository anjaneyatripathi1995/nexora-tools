@extends('layouts.app')
@section('title', $title ?? ($tool['name'] ?? 'Tool'))
@section('meta_description', $description ?? ($tool['description'] ?? 'Free online tool by Nexora Tools.'))
@stack('meta')
