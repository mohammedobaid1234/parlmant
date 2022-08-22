$('#select3').on('change', function() {
    const id = this.value;
    
    $.get("http://localhost:8000/admin/users/children/" +id, function(data){
        console.log(data.length);
        if(data.length == 0){
            $('#select-main1').css('display' , 'none')
            $('#select3').attr('name' , 'council_id');

        }else{
            console.log('object');
            $('#select-main1').empty()
            $('#select3').attr('name' , '');
            $('#select-main1').css('display' , 'block')
            for(i=0 ; i<data.length ; i++){
                item = data[i];
            $('#select-main1').append(
                `<option id='options' name="council_id" value=${item.id} class="form-control">${item.name}</option>`         
            );
            }
        }
        
    });
});
// $('#select1').on('change', function() {
//     console.log(id);
//     const id = this.value;
//     $.get("http://localhost:8000/admin/users/create/" +id, function(data){
//         // console.log(data.length);
//         if(data.length == 0){
//             $('#select1').attr('name' , 'parent_id');
//             $('#select-main').css('display' , 'none')

//         }else{
//             console.log('object');
//             $('#select-main').empty()
//             $('#select1').attr('name' , '');
//             $('#select-main').css('display' , 'block')
//             for(i=0 ; i<data.length ; i++){
//                 item = data[i];
//             $('#select-main').append(
//                 `<option id='options' name="parent_id" value=${item.id} class="form-control">${item.name}</option>`         
//             );
//             }
//         }
        
//     });
// });
const type1 = document.getElementById("type1");
const type2 = document.getElementById("type2");
const type3 = document.getElementById("type3");

const council = document.getElementById("council");
const password = document.getElementById("password-admin");
type2.addEventListener("click", function () {
    council.style.display = "none";
    password.style.display = "none";
});
type1.addEventListener("click", function () {
    council.style.display = "block";
    password.style.display = "none";
});
type3.addEventListener("click", function () {
    council.style.display = "none";
    password.style.display = "block";
});
