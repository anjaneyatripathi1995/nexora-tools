<div class="tool-form-wrap">
    <div style="background:var(--bg-elevated);border:1.5px solid var(--border);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:12px;margin-bottom:24px">
        <code id="pwOut" style="flex:1;font-size:1.1rem;font-family:monospace;word-break:break-all;color:var(--text)">Click Generate</code>
        <button class="btn btn-outline-secondary btn-sm" onclick="copyPw()">Copy</button>
    </div>
    <div class="mb-3">
        <div style="display:flex;justify-content:space-between;font-size:.82rem;color:var(--text-2);margin-bottom:6px"><span>Strength</span><span id="strLabel" style="font-weight:600">—</span></div>
        <div style="height:6px;background:var(--border);border-radius:3px;overflow:hidden"><div id="strBar" style="height:100%;width:0;border-radius:3px;transition:width .4s,background .4s"></div></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Length: <strong id="lenVal">16</strong></label>
        <input type="range" id="lenSlider" min="6" max="64" value="16" class="form-range">
    </div>
    <div class="mb-3 d-flex flex-wrap gap-3">
        <label class="form-check"><input type="checkbox" class="form-check-input" id="upper" checked> Uppercase (A-Z)</label>
        <label class="form-check"><input type="checkbox" class="form-check-input" id="lower" checked> Lowercase (a-z)</label>
        <label class="form-check"><input type="checkbox" class="form-check-input" id="nums" checked> Numbers (0-9)</label>
        <label class="form-check"><input type="checkbox" class="form-check-input" id="syms" checked> Symbols (!@#\$)</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Count</label>
        <select id="cnt" class="form-select form-select-sm" style="max-width:140px">
            <option value="1">1 password</option>
            <option value="5">5 passwords</option>
            <option value="10">10 passwords</option>
        </select>
    </div>
    <button class="btn btn-primary" onclick="pwGenerate()">Generate Password</button>
    <div id="multiOut" class="mt-3" style="display:none">
        <label class="form-label small">All generated</label>
        <textarea class="form-control font-monospace small" id="multiList" rows="4" readonly></textarea>
    </div>
</div>

@push('scripts')
<script>
(function(){
var cs={upper:'ABCDEFGHIJKLMNOPQRSTUVWXYZ',lower:'abcdefghijklmnopqrstuvwxyz',nums:'0123456789',syms:'!@#$%^&*()_+-=[]{}|;:,.<>?'};
document.getElementById('lenSlider').addEventListener('input',function(){document.getElementById('lenVal').textContent=this.value});
window.pwGenerate=function(){
    var len=+document.getElementById('lenSlider').value;
    var cnt=+document.getElementById('cnt').value;
    var sel=Object.entries(cs).filter(function(kv){return document.getElementById(kv[0])&&document.getElementById(kv[0]).checked;}).map(function(kv){return kv[1];});
    if(!sel.length){alert('Select at least one character type.');return;}
    var pool=sel.join('');
    var pws=Array.from({length:cnt},function(){
        var a=new Uint8Array(len);
        crypto.getRandomValues(a);
        return Array.from(a).map(function(b){return pool[b%pool.length];}).join('');
    });
    document.getElementById('pwOut').textContent=pws[0];
    var bar=document.getElementById('strBar'),lab=document.getElementById('strLabel');
    var pw=pws[0];
    var s=0;if(pw.length>=8)s++;if(pw.length>=12)s++;if(pw.length>=16)s++;if(sel.length>=2)s++;if(sel.length>=4)s++;
    var lvl=[[20,'#EF4444','Very Weak'],[40,'#F97316','Weak'],[60,'#F59E0B','Fair'],[80,'#10B981','Strong'],[100,'#059669','Very Strong']];
    var x=lvl[Math.min(s,4)];bar.style.width=x[0]+'%';bar.style.background=x[1];lab.textContent=x[2];lab.style.color=x[1];
    var mo=document.getElementById('multiOut');
    if(cnt>1){mo.style.display='block';document.getElementById('multiList').value=pws.join('\n');}else{mo.style.display='none';}
}
window.copyPw=function(){var t=document.getElementById('pwOut').textContent;if(t&&t!=='Click Generate'){navigator.clipboard&&navigator.clipboard.writeText(t).then(function(){alert('Copied!');});}};
if(document.readyState!=='loading')window.pwGenerate();else document.addEventListener('DOMContentLoaded',function(){window.pwGenerate();});
})();
</script>
@endpush
