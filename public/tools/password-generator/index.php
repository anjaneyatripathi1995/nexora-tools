<?php
$page_title = 'Password Generator — Strong & Secure';
$page_desc  = 'Generate strong, random passwords instantly. Customise length and character types. Free and private.';
require ROOT . '/includes/header.php';
?>
<div class="sub-banner"><div class="container"><div class="sub-banner-inner">
    <h1>🔑 Password Generator</h1><p>Generate strong, random passwords instantly</p>
    <div class="breadcrumb"><a href="<?= BASE_URL ?>">Home</a> / <a href="<?= BASE_URL ?>tools">Tools</a> / Password Generator</div>
</div></div></div>
<section class="tool-page"><div class="container" style="max-width:640px">
    <div class="tool-wrap">
        <div style="background:var(--bg-elevated);border:1.5px solid var(--border);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:12px;margin-bottom:24px">
            <code id="pwOut" style="flex:1;font-size:1.1rem;font-family:monospace;word-break:break-all;color:var(--text)">Click Generate</code>
            <button class="btn btn-ghost btn-sm" onclick="copyPw()">📋 Copy</button>
        </div>
        <div style="margin-bottom:24px">
            <div style="display:flex;justify-content:space-between;font-size:.82rem;color:var(--text-2);margin-bottom:6px"><span>Strength</span><span id="strLabel" style="font-weight:600">—</span></div>
            <div style="height:6px;background:var(--border);border-radius:3px;overflow:hidden"><div id="strBar" style="height:100%;width:0;border-radius:3px;transition:width .4s,background .4s"></div></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
            <div class="form-group" style="grid-column:span 2;margin-bottom:0"><label class="form-label">Length: <strong id="lenVal">16</strong></label><input type="range" id="lenSlider" min="6" max="64" value="16" style="width:100%;accent-color:var(--primary)"></div>
            <?php foreach([['upper','Uppercase (A-Z)',true],['lower','Lowercase (a-z)',true],['nums','Numbers (0-9)',true],['syms','Symbols (!@#$)',true]] as [$id,$label,$chk]): ?>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.875rem;font-weight:500;color:var(--text-2)">
                <input type="checkbox" id="<?= $id ?>" <?= $chk?'checked':'' ?> style="accent-color:var(--primary);width:16px;height:16px"> <?= $label ?>
            </label>
            <?php endforeach; ?>
        </div>
        <div class="form-group"><label class="form-label">Count</label><select id="cnt" class="form-select"><option value="1">1 password</option><option value="5">5 passwords</option><option value="10">10 passwords</option></select></div>
        <button class="btn btn-primary w-full btn-lg" onclick="generate()">🔑 Generate Password</button>
        <div id="multiOut" style="margin-top:20px;display:none"><label class="form-label">All generated</label><div id="multiList" class="result-box" style="min-height:80px"></div></div>
    </div>
</div></section>
<script>
const cs={upper:'ABCDEFGHIJKLMNOPQRSTUVWXYZ',lower:'abcdefghijklmnopqrstuvwxyz',nums:'0123456789',syms:'!@#$%^&*()_+-=[]{}|;:,.<>?'};
document.getElementById('lenSlider').addEventListener('input',function(){document.getElementById('lenVal').textContent=this.value});
function generate(){
    const len=+document.getElementById('lenSlider').value;
    const cnt=+document.getElementById('cnt').value;
    const sel=Object.entries(cs).filter(([k])=>document.getElementById(k)?.checked).map(([,v])=>v);
    if(!sel.length){alert('Select at least one character type.');return}
    const pool=sel.join('');
    const pws=Array.from({length:cnt},()=>{const a=new Uint8Array(len);crypto.getRandomValues(a);return Array.from(a).map(b=>pool[b%pool.length]).join('')});
    document.getElementById('pwOut').textContent=pws[0];
    updateStr(pws[0],sel.length);
    const mo=document.getElementById('multiOut');
    if(cnt>1){mo.style.display='block';document.getElementById('multiList').textContent=pws.join('\n')}else{mo.style.display='none'}
}
function updateStr(pw,types){
    const bar=document.getElementById('strBar'),lab=document.getElementById('strLabel');
    let s=0;if(pw.length>=8)s++;if(pw.length>=12)s++;if(pw.length>=16)s++;if(types>=2)s++;if(types>=4)s++;
    const lvl=[[20,'#EF4444','Very Weak'],[40,'#F97316','Weak'],[60,'#F59E0B','Fair'],[80,'#10B981','Strong'],[100,'#059669','Very Strong']];
    const[p,c,t]=lvl[Math.min(s,4)];bar.style.width=p+'%';bar.style.background=c;lab.textContent=t;lab.style.color=c;
}
function copyPw(){const t=document.getElementById('pwOut').textContent;if(t!=='Click Generate')nexoraCopy(t,event.target)}
generate();
</script>
<?php require ROOT . '/includes/footer.php'; ?>
