@extends('layouts.site')

@php
    $pageTitle = 'JSON Formatter & Validator';
    $pageDesc  = 'Format, validate and beautify JSON data online - free, instant, works in browser.';
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{ } JSON Formatter</h1>
            <p>Format, validate and beautify JSON instantly</p>
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> /
                <a href="{{ route('tools.index') }}">Tools</a> /
                JSON Formatter
            </div>
        </div>
    </div>
</div>

<section class="tool-page">
    <div class="container" style="max-width:1100px">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
            <div class="tool-wrap">
                <div class="tool-header"><h2>Input JSON</h2><p>Paste your raw or minified JSON</p></div>
                <div class="form-group"><textarea class="form-textarea" id="jsonInput" style="min-height:320px;font-size:.82rem" placeholder='{"name":"Nexora","free":true}'></textarea></div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <button class="btn btn-primary" onclick="formatJson()">Format</button>
                    <button class="btn btn-ghost btn-sm" onclick="minifyJson()">Minify</button>
                    <button class="btn btn-ghost btn-sm" onclick="clearAll()">Clear</button>
                    <button class="btn btn-ghost btn-sm" onclick="loadSample()">Sample</button>
                </div>
            </div>
            <div class="tool-wrap">
                <div class="tool-header" style="display:flex;align-items:center;justify-content:space-between">
                    <div><h2>Output</h2><p id="statusMsg" style="color:var(--success)">Ready</p></div>
                    <button class="btn btn-ghost btn-sm" onclick="nexoraCopy(document.getElementById('jsonOutput').textContent, this)">Copy</button>
                </div>
                <pre class="result-box" id="jsonOutput" style="min-height:320px">Formatted JSON will appear here...</pre>
            </div>
        </div>
        <div class="tool-wrap" style="margin-top:24px">
            <h3 style="margin-bottom:12px">About JSON Formatter</h3>
            <p style="color:var(--text-2);line-height:1.7;font-size:.9rem">Validates JSON for syntax errors and formats it with proper indentation. Works entirely in your browser - no data sent to any server. Press Ctrl+Enter to format.</p>
        </div>
    </div>
</section>

<script>
const inp=document.getElementById('jsonInput'),out=document.getElementById('jsonOutput'),st=document.getElementById('statusMsg');
function setS(m,ok){st.textContent=m;st.style.color=ok?'var(--success)':'var(--danger)'}
function formatJson(){const r=inp.value.trim();if(!r){setS('Enter JSON first',false);return}try{out.textContent=JSON.stringify(JSON.parse(r),null,2);setS('Valid JSON',true)}catch(e){out.textContent='Error: '+e.message;setS('Invalid JSON',false)}}
function minifyJson(){const r=inp.value.trim();if(!r)return;try{out.textContent=JSON.stringify(JSON.parse(r));setS('Minified',true)}catch(e){setS(e.message,false)}}
function clearAll(){inp.value='';out.textContent='Formatted JSON will appear here...';setS('Ready',true)}
function loadSample(){inp.value=JSON.stringify({site:'Nexora Tools',url:'tripathinexora.com',tools:40,free:true,categories:['Finance','PDF','Developer','Image','Text','SEO','AI']});formatJson()}
inp.addEventListener('keydown',e=>{if((e.ctrlKey||e.metaKey)&&e.key==='Enter')formatJson()});
</script>
@endsection