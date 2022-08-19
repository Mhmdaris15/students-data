// Pure Javascript Approaching
// let searchbox = document.getElementById('searchbox');
// let searchbutton = document.getElementById('search-btn');
// let container = document.getElementById('container');

// searchbox.addEventListener('keypress', e => {
//     // Create AJAX Object
//     let xhr = new XMLHttpRequest();

//     // Check AJAX status
//     xhr.onreadystatechange = () => {
//         if (xhr.readyState == 4 && xhr.status == 200){
//             container.innerHTML = xhr.responseText; // Display response
//         }
//     }

//     // AJAX Request
//     xhr.open('GET', 'ajax/mahasiswa.php?searchbox=' + searchbox.value, true); // true = asynchronous
//     xhr.send(); 
// });

// JQuery approaching
$(document).ready(function () {

    // $('#search-btn').hide(); 

    $("#loader").hide();
    $("#searchbox").keypress(function () {
        $("#loader").show();
        $.ajax({
            url: 'ajax/mahasiswa.php',
            data: 'searchbox=' + $('#searchbox').val(),
            success: function (data) {
                $("#container").html(data);
                $("#loader").hide();
            }
        })
    });

});
