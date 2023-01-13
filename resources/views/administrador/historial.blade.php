@extends("layouts.admin")
@section("content")

<div class="con">
{{-- <h1 id="titulo-carga">Historial de Justificaciones</h1> --}}

<input id="rut" oninput="formatPhone(this);" maxlength="12" placeholder="6.234.998-6" class="form-control">
<button id="submit" class="btn btn-warning">Buscar</button>
</div>
<div id="list"></div>
{{-- <h1 id="h1"></h1> --}}

<style>
    #list {
        margin-top: 30px;
    }
    h1 {
        
        font-size: 20px;
    }
    
    span {
        font-size: 23px;
    }

    .con {
        margin: auto;
        width: 300px;
    }

    #rut, button {
        width: 200px;
        /* height: 30px; */
    }
    button {
        /* width: 100px; */
        height: 30px;
        /* display: block; */
        color: white;
    }

    .row {
        display: flex;
        /* flex-direction: column; */
    }

    #list {
        /* display: flex; */
        /* flex-direction: row; */
        margin: 20px auto 0;
        width: 500px;
    }

    #fecha, #asig, #estado {
        width: 100px;
    }

    #btn-detalles {
        width: 100px;
    }

</style>
@endsection
@section('utilities')
<script>
// $(document).ready(function() {
//     let btn = document.getElementById('xx');
//     btn.onclick = function() {
//         console.log(1111);
//     }
// })

let btn = document.getElementById('submit');
let rut = document.getElementById('rut');
let list = document.getElementById('list');
// let h1 = document.getElementById('h1');
btn.onclick = function() {
    // console.log(rut.value);
    fetchJusti(rut.value).then(e => {
        let output = '';
        console.log(e['users']);
        let a = e['users'];
        a.forEach(e => {
            console.log(e._id);
            output += `
                <div class="row">
                    <div id="fecha">${e.FEC_SOL}</div>
                    <div id="asig">${e.ASIGNATURA}</div>
                    <div id="estado">${e.ESTADO}</div>
                    
                    <div id="div-detalles"><button id="btn-detalles" class="btn btn-info">Ver</button></div>
                    
                    </div>
            `
            // console.log(e)
        })
        list.innerHTML = output;

        // console.log(e.users);
    })
}

async function fetchJusti(pid){
    // let res = await fetch('https://mongo-api.camiluc.vercel.app/api/justi/187816858');
    pid = pid.replace(/\D/g, '');
    let res = await fetch(`https://mongo-api.camiluc.vercel.app/api/justi/${pid}`);
    let justi = await res.json();
    return justi;

}

function formatPhone(obj) {
    console.log(obj);
    let short = { 1:'.' , 4:'.', 7:'-'};
    let large = { 2:'.' , 5:'.', 8:'-'};
    
    let numbers = obj.value.replace(/\D/g, '');
    
    if (numbers.length < 9) {
    char = short;
    } else {
    char = large;
    }
    console.log(numbers);
    obj.value = '';
    for (var i = 0; i < numbers.length; i++) {
        obj.value += (char[i]||'') + numbers[i];
    }
 }

// fetchJusti().then(e => {
//     console.log(e)
// })

// fetch('https://mongo-api.camiluc.vercel.app/api/justi/187816858')
//     .then(response => response.json())
//     .then(data => {

//         console.log(data.users[0]);   
// })
    
</script>
@endsection