$(document).ready(function() {

    // Basic DataTable
    $('#basicExample, #demoRequests #paymentExample').DataTable({
        "iDisplayLength": 10,
        "language": {
            "searchPlaceholder": 'Search...',
            "sSearch": '',
            "lengthMenu": '_MENU_ items/page',
            // "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "No matching records found",
            // "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "processing": true,
        // "scrollY":        "200px",
        // "scrollCollapse": true,
    });

    // Url for more info on datepicker options https://xdsoft.net/jqplugins/datetimepicker/
    $(document).on('click', '#service-date-time', function() {
        $('#service-date-time').datetimepicker({
            // format: 'L', //LT for time only
            // inline: true,
            // sideBySide: true,
            timepicker:false,
            format: 'Y/m/d',
            formatDate: 'Y/m/d',
            minDate: '-1970/01/02', // yesterday is minimum date
            mask: true,
        });
    });

    $(document).on('click', '#supplier-delivery-date', function() {
        $('#supplier-delivery-date').datetimepicker({
            // format: 'L', //LT for time only
            // inline: true,
            // sideBySide: true,
            timepicker:true,
            format: 'Y/m/d H:i',
            formatDate: 'Y/m/d',
            minDate: '-1970/01/02', // yesterday is minimum date
            mask: true,
        });
    });

    //Prevent characters or string asides number in phone number input field
    $("#phone_number, #other_phone_number, #account_number, .amount").on("keypress keyup blur", function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    //Close bootstrap modal backdrop on click
    $('.close').click(function() {
        $(".modal-backdrop").remove();
    });

    //Set Payment max date to Today's date
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#payment_date, #date_to, #date_from, #specific_date, #date_of_birth, #expiry_date').attr('max', today);

    //Delete feature sweetalert dialog
    $(document).on('click', '.delete-entity', function(e) {
        e.preventDefault();
        var route = $(this).data('url');
        var title = $(this).attr('title');

        Swal.fire({
            title: title + '?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#7987a1',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {
                window.location.href = route;
            }
        });
    });

    //Deactivate feature sweetalert dialog
    $(document).on('click', '.deactivate-entity', function(e) {
        e.preventDefault();
        var route = $(this).data('url')
        var title = $(this).attr('title');

        Swal.fire({
            title: title + '?',
            text: "You will be able to reinstate afterwards!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#7987a1',
            confirmButtonText: 'Yes, deactivate it!'
        }).then((result) => {
            if (result.value == true) {
                window.location.href = route;
            }
        });
    });

});

//Initialise TinyMCE editor
tinymce.init({
    selector: '#message_body',
    height: 200,
    theme: 'modern',
    plugins: [
        'advlist autolink lists charmap hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars',
        'insertdatetime nonbreaking save table contextmenu directionality',
        'emoticons paste textcolor colorpicker textpattern'
    ],
    toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    toolbar2: 'forecolor backcolor emoticons',
    image_advtab: true
});

//Feedback from session message to be displayed with Sweet Alert
function displayMessage(message, type) {
    const Toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 8000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: type,
        //   type: 'success',
        title: message
    });
}

// $(function(){
//     'use strict'

//     var ctx1 = document.getElementById('chartBar1').getContext('2d');
//     new Chart(ctx1, {
//       type: 'bar',
//       data: {
//         labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
//         datasets: [{
//           data: [150,110,90,115,125,160,160,140,100,110,120,120],
//           backgroundColor: '#66a4fb'
//         },{
//           data: [180,140,120,135,155,170,180,150,140,150,130,130],
//           backgroundColor: '#65e0e0'
//         }]
//       },
//       options: {
//         maintainAspectRatio: false,
//         legend: {
//           display: false,
//             labels: {
//               display: false
//             }
//         },
//         scales: {
//           xAxes: [{
//             display: false,
//             barPercentage: 0.5
//           }],
//           yAxes: [{
//             gridLines: {
//               color: '#ebeef3'
//             },
//             ticks: {
//               fontColor: '#8392a5',
//               fontSize: 10,
//               min: 80,
//               max: 200
//             }
//           }]
//         }
//       }
//     });


//     /** PIE CHART **/
//     var datapie = {
//       labels: ['Organic Search', 'Email', 'Referral', 'Social Media'],
//       datasets: [{
//         data: [20,20,30,25],
//         backgroundColor: ['#f77eb9', '#7ebcff','#7ee5e5','#fdbd88']
//       }]
//     };

//     var optionpie = {
//       maintainAspectRatio: false,
//       responsive: true,
//       legend: {
//         display: false,
//       },
//       animation: {
//         animateScale: true,
//         animateRotate: true
//       }
//     };

//     // For a pie chart
//     var ctx2 = document.getElementById('chartDonut');
//     var myDonutChart = new Chart(ctx2, {
//       type: 'doughnut',
//       data: datapie,
//       options: optionpie
//     });


//     $.plot('#flotChart1', [{
//         data: df1,
//         color: '#c0ccda',
//         lines: {
//           fill: true,
//           fillColor: '#f5f6fa'
//         }
//       },{
//           data: df3,
//           color: '#E97D1F',
//           lines: {
//             fill: true,
//             fillColor: '#d1e6fa'
//           }
//         }], {
//             series: {
//                 shadowSize: 0,
//         lines: {
//           show: true,
//           lineWidth: 1.5
//         }
//             },
//       grid: {
//         borderWidth: 0,
//         labelMargin: 0
//       },
//             yaxis: {
//         show: false,
//         max: 65
//       },
//             xaxis: {
//         show: false,
//         min: 40,
//         max: 100
//       }
//         });


//     $.plot('#flotChart2', [{
//       data: df2,
//       color: '#66a4fb',
//       lines: {
//         show: true,
//         lineWidth: 1.5,
//         fill: .03
//       }
//     },{
//       data: df1,
//       color: '#00cccc',
//       lines: {
//         show: true,
//         lineWidth: 1.5,
//         fill: true,
//         fillColor: '#fff'
//       }
//     },{
//       data: df3,
//       color: '#e3e7ed',
//       bars: {
//         show: true,
//         lineWidth: 0,
//         barWidth: .5,
//         fill: 1
//       }
//     }], {
//       series: {
//         shadowSize: 0
//       },
//       grid: {
//         aboveData: true,
//         color: '#e5e9f2',
//         borderWidth: {
//           top: 0,
//           right: 1,
//           bottom: 1,
//           left: 1
//         },
//         labelMargin: 0
//       },
//             yaxis: {
//         show: false,
//         min: 0,
//         max: 100
//       },
//             xaxis: {
//         show: true,
//         min: 40,
//         max: 80,
//         ticks: 6,
//         tickColor: 'rgba(0,0,0,0.04)'
//       }
//         });

//     var df3data1 = [[0,12],[1,10],[2,7],[3,11],[4,15],[5,20],[6,22],[7,19],[8,18],[9,20],[10,17],[11,19],[12,18],[13,14],[14,9]];
//     var df3data2 = [[0,0],[1,0],[2,0],[3,2],[4,5],[5,2],[6,12],[7,15],[8,10],[9,8],[10,10],[11,7],[12,2],[13,4],[14,0]];
//     var df3data3 = [[0,2],[1,1],[2,2],[3,4],[4,2],[5,1],[6,0],[7,0],[8,5],[9,2],[10,8],[11,6],[12,9],[13,2],[14,0]];
//     var df3data4 = [[0,0],[1,5],[2,2],[3,0],[4,2],[5,7],[6,10],[7,12],[8,8],[9,6],[10,4],[11,2],[12,0],[13,0],[14,0]];

//     var flotChartOption1 = {
//       series: {
//         shadowSize: 0,
//         bars: {
//           show: true,
//           lineWidth: 0,
//           barWidth: .5,
//           fill: 1
//         }
//       },
//       grid: {
//         aboveData: true,
//         color: '#e5e9f2',
//         borderWidth: 0,
//         labelMargin: 0
//       },
//             yaxis: {
//         show: false,
//         min: 0,
//         max: 25
//       },
//             xaxis: {
//         show: false
//       }
//         };

//     $.plot('#flotChart3', [{
//       data: df3data1,
//       color: '#e5e9f2'
//     },{
//       data: df3data2,
//       color: '#66a4fb'
//     }], flotChartOption1);


//     $.plot('#flotChart4', [{
//       data: df3data1,
//       color: '#e5e9f2'
//     },{
//       data: df3data3,
//       color: '#7ee5e5'
//     }], flotChartOption1);

//     $.plot('#flotChart5', [{
//       data: df3data1,
//       color: '#e5e9f2'
//     },{
//       data: df3data4,
//       color: '#f77eb9'
//     }], flotChartOption1);

//   })