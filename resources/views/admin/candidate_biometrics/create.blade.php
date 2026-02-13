@extends('admin.layouts.app')

@section('content')

<style>
.camera-frame{
    position:relative;
    width:420px;
    height:420px;
    border-radius:20px;
    overflow:hidden;
    border:4px solid #6366f1;
}
#overlay{
    position:absolute;
    top:0;
    left:0;
}
.progress-bar{
    height:20px;
    background:#e5e7eb;
    border-radius:10px;
    overflow:hidden;
}
.progress-fill{
    height:100%;
    width:0%;
    background:#10b981;
    transition:0.3s;
}
.status-box{
    font-weight:600;
}
</style>

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-indigo-600 mb-6">
🧬 Advanced Biometric Verification
</h2>

<form method="POST" action="{{ route('admin.candidate-biometrics.store') }}">
@csrf

<div class="bg-white p-6 rounded-3xl shadow-lg">

<select name="candidate_id" class="w-full border p-2 rounded mb-6">
@foreach($candidates as $candidate)
<option value="{{ $candidate->id }}">
{{ $candidate->full_name }}
</option>
@endforeach
</select>

<div class="grid grid-cols-2 gap-10">

{{-- FACE SECTION --}}
<div>

<h3 class="font-bold mb-3">🎥 External Camera Face Detection</h3>

<select id="cameraSelect" class="border p-2 rounded mb-3 w-full"></select>

<div class="camera-frame">
<video id="video" width="420" height="420" autoplay muted playsinline></video>
<canvas id="overlay"></canvas>
</div>

<input type="hidden" name="face_descriptor" id="face_descriptor">
<input type="hidden" name="face_match_score" id="face_match_score">

<div id="faceStatus" class="status-box mt-3 text-blue-600">
Loading Models...
</div>

<div class="progress-bar mt-4">
<div id="completionBar" class="progress-fill"></div>
</div>

</div>

{{-- FINGER SECTION --}}
<div>

<h3 class="font-bold mb-3">👆 Fingerprint Verification</h3>

<button type="button"
onclick="scanFinger()"
class="bg-indigo-600 text-white px-4 py-2 rounded">
Scan Finger
</button>

<div id="fingerStatus" class="status-box mt-3 text-yellow-600">
⏳ Waiting
</div>

<input type="hidden" name="finger_pid" id="finger_pid">

<div class="mt-6 font-bold text-red-600" id="fraudScore">
Fraud Score: 0%
</div>

</div>

</div>

<button type="submit"
class="mt-6 bg-green-600 text-white px-6 py-3 rounded">
Save Verification
</button>

</div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/face-api.js/dist/face-api.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", async function(){

let video = document.getElementById("video");
let canvas = document.getElementById("overlay");
let ctx = canvas.getContext("2d");
let cameraSelect = document.getElementById("cameraSelect");

let completion = 0;
let fraud = 0;

// ================= LOAD MODELS =================
await faceapi.nets.tinyFaceDetector.loadFromUri("{{ asset('models') }}");
await faceapi.nets.faceLandmark68Net.loadFromUri("{{ asset('models') }}");
await faceapi.nets.faceRecognitionNet.loadFromUri("{{ asset('models') }}");

document.getElementById("faceStatus").innerHTML =
"✔ Models Loaded";

// ================= LOAD CAMERAS =================
async function loadCameras(){
const devices = await navigator.mediaDevices.enumerateDevices();
const videoDevices = devices.filter(d => d.kind === "videoinput");

cameraSelect.innerHTML = "";

videoDevices.forEach((device,index)=>{
let option = document.createElement("option");
option.value = device.deviceId;
option.text = device.label || "Camera "+(index+1);
cameraSelect.appendChild(option);
});

// 🔥 External camera priority (usually not first)
if(videoDevices.length > 1){
cameraSelect.selectedIndex = 1;
}

startCamera(cameraSelect.value);

cameraSelect.onchange = ()=>{
startCamera(cameraSelect.value);
};
}

let currentStream;

async function startCamera(deviceId){

if(currentStream){
currentStream.getTracks().forEach(track=>track.stop());
}

currentStream = await navigator.mediaDevices.getUserMedia({
video:{
deviceId: { exact: deviceId }
}
});

video.srcObject = currentStream;

video.addEventListener("play",()=>{
canvas.width = video.videoWidth;
canvas.height = video.videoHeight;

setInterval(async ()=>{

const detection = await faceapi
.detectSingleFace(video,new faceapi.TinyFaceDetectorOptions())
.withFaceLandmarks()
.withFaceDescriptor();

ctx.clearRect(0,0,canvas.width,canvas.height);

if(detection){

const resized = faceapi.resizeResults(detection,{
width:canvas.width,
height:canvas.height
});

faceapi.draw.drawDetections(canvas,resized);

completion = 50;
updateCompletion();

document.getElementById("faceStatus").innerHTML =
"✔ Face Detected";

let descriptor = detection.descriptor;
document.getElementById("face_descriptor").value =
JSON.stringify(Array.from(descriptor));

}else{
document.getElementById("faceStatus").innerHTML =
"❌ No Face Detected";
}

},1500);
});
}

loadCameras();

// ================= RD FINGER =================
window.scanFinger = function(){

let xml = `
<PidOptions ver="1.0">
<Opts fCount="1" format="0"
pidVer="2.0" timeout="10000"/>
</PidOptions>`;

let xhr = new XMLHttpRequest();

xhr.open("CAPTURE","https://127.0.0.1:11100/rd/capture",true);
xhr.setRequestHeader("Content-Type","text/xml");

xhr.onreadystatechange = function(){
if(xhr.readyState === 4){
if(xhr.status === 200){

document.getElementById("finger_pid").value =
xhr.responseText;

document.getElementById("fingerStatus").innerHTML =
"✔ Finger Captured";

completion = 100;
updateCompletion();

}else{
document.getElementById("fingerStatus").innerHTML =
"❌ RD Error";
}
}
};

xhr.send(xml);
}

// ================= UI =================
function updateCompletion(){
document.getElementById("completionBar").style.width =
completion+"%";
}

});
</script>

@endsection
