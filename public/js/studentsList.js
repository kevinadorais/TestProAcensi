
var getStudents = async function(){

    let response = await fetch("http://127.0.0.1:8000/api/departments/11") ;
    if(response.ok){
        let data = await response.json ;
        console.log(data['student']) ;
    }
    
}

getStudents();