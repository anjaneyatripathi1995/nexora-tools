<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tripathi Nexora Technologies | Coming Soon</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    color:#fff;
    overflow:hidden;
    background: linear-gradient(-45deg,#0f2027,#203a43,#2c5364,#141e30);
    background-size:400% 400%;
    animation:gradientBG 12s ease infinite;
}

@keyframes gradientBG{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

/* Floating particles */
body::before{
    content:"";
    position:absolute;
    width:200%;
    height:200%;
    background-image:radial-gradient(white 1px, transparent 1px);
    background-size:50px 50px;
    opacity:0.05;
    animation:moveParticles 60s linear infinite;
}

@keyframes moveParticles{
    from{transform:translate(0,0);}
    to{transform:translate(-500px,-500px);}
}

.container{
    position:relative;
    z-index:2;
    padding:50px;
    border-radius:20px;
    backdrop-filter:blur(20px);
    background:rgba(255,255,255,0.08);
    box-shadow:0 0 40px rgba(0,0,0,0.4);
    max-width:750px;
    animation:fadeUp 1.5s ease forwards;
}

@keyframes fadeUp{
    from{opacity:0; transform:translateY(40px);}
    to{opacity:1; transform:translateY(0);}
}

.logo{
    font-size:34px;
    font-weight:700;
    letter-spacing:2px;
    margin-bottom:15px;
}

.logo span{
    color:#00f2ff;
    text-shadow:0 0 10px #00f2ff,
                0 0 20px #00f2ff,
                0 0 40px #00f2ff;
}

h1{
    font-size:42px;
    margin-bottom:15px;
}

p{
    font-size:18px;
    opacity:0.8;
    margin-bottom:30px;
}

.countdown{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-bottom:35px;
}

.box{
    padding:20px;
    border-radius:15px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    min-width:90px;
}

.box h2{
    font-size:28px;
}

.box span{
    font-size:12px;
    opacity:0.7;
}

/* Email Form */
form{
    margin-top:20px;
}

input{
    padding:12px 15px;
    border-radius:30px;
    border:none;
    outline:none;
    width:250px;
}

button{
    padding:12px 25px;
    border:none;
    border-radius:30px;
    margin-left:10px;
    background:#00f2ff;
    color:#000;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#00c3cc;
    box-shadow:0 0 15px #00f2ff;
}

.footer{
    margin-top:30px;
    font-size:14px;
    opacity:0.6;
}
</style>
</head>

<body>

<div class="container">
    <div class="logo">Tripathi <span>Nexora</span> Technologies</div>

    <h1>Launching Soon 🚀</h1>
    <p>We are crafting next-generation digital solutions. Stay tuned for innovation.</p>

    <div class="countdown">
        <div class="box"><h2 id="days">00</h2><span>Days</span></div>
        <div class="box"><h2 id="hours">00</h2><span>Hours</span></div>
        <div class="box"><h2 id="minutes">00</h2><span>Minutes</span></div>
        <div class="box"><h2 id="seconds">00</h2><span>Seconds</span></div>
    </div>

    <form>
        <input type="email" placeholder="Enter your email">
        <button type="submit">Notify Me</button>
    </form>

    <div class="footer">
        © 2026 Tripathi Nexora Technologies. All Rights Reserved.
    </div>
</div>

<script>
const launchDate = new Date("Apr 30, 2026 00:00:00").getTime();

const timer = setInterval(function(){
    const now = new Date().getTime();
    const distance = launchDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("days").innerHTML = days;
    document.getElementById("hours").innerHTML = hours;
    document.getElementById("minutes").innerHTML = minutes;
    document.getElementById("seconds").innerHTML = seconds;

    if(distance < 0){
        clearInterval(timer);
        document.querySelector(".countdown").innerHTML = "🚀 We Are Live!";
    }
},1000);
</script>

</body>
</html>