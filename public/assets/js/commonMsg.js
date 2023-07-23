'use strict';
console.log("HIIIII USER!");

// Delete confirmation with swal sweet alert message
window.deleteConfirm = function (e) 
{
  e.preventDefault();
  var form = e.target.form;
  swal({
      title: "Are you sure you want to delete?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      })
    .then((del) =>
     {
      if (del)
      {
        document.getElementById("mybtn").submit();          
      }
     });
}

// Tab content
function openCity(evt, details)
{
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) 
    {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) 
    {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(details).style.display = "block";
    evt.currentTarget.className += " active";
}

// Toggle Status
function status(id,status,urldata)
{
    $.ajaxSetup({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
               });

  var stp=document.getElementById('status' +id).title;
    if(stp=="Active")
    {
      status='0';
    }
    if(stp=="Inactive")
    {
      status='1';
    }
  var param = "/"+urldata;
  jQuery.ajax({ 
    url:param,
    method: 'POST',
    data: {id, status},
    dataType: 'json',
    success:function (response)
    {        
        if(response.status=="1")
        {
        document.getElementById('status'+id).title="Active";
        }
        if(response.status=="0")
        {
          document.getElementById('status'+id).title="Inactive";
        }
    }
  })
}

  // var lead_source_TL = $("#lead_source_TL").val();
  // if (lead_source_TL != '') onLeadSourceTL(lead_source_TL);

  // var up_lead_source_TL = $("#up_lead_source_TL").val();
  // if (up_lead_source_TL != '') updateTL(up_lead_source_TL);

// var lead_source_sm = $("#lead_source_sm").val();
// if (lead_source_sm != '') onLeadSourceSM(lead_source_sm);

// var up_lead_source_sm = $("#up_lead_source_sm").val();
// if (up_lead_source_sm = '') updateSM(up_lead_source_sm);

//display dynamic dependent value in dropdown

$(document).ready(function()
 {
  
      $('#status').select2('destroy');
    var oldSanctionId = $('#old_sanction_id').val();
    if (oldSanctionId !== '') {
        $('#sanction_id').append($('<option>', {
            value: oldSanctionId,
            text: oldSanctionId,
            selected: 'selected'
        }));
      }
       var oldSanctionId = $('#new_sanction_id').val();
    if (oldSanctionId !== '') {
        $('#sanction_id').append($('<option>', {
            value: oldSanctionId,
            text: oldSanctionId,
            selected: 'selected'
        }));
      }
    
    var last_sanction_id = $('#sanction_id').val();
    console.log("last_sanction_id", last_sanction_id);  
    $('.dynamic').change(function() 
    {
    // console.log("this val", $(this).val);   
    if ($(this).val() != '') 
    {
      var select = $(this).attr("id");
      var value = $(this).val();
      var dependent = $(this).data('dependent');
      var _token = $('input[name="_token"]').val();

      $.ajax({
              url: '/dynamic_dependent/fetch',
              method: "POST",
              data: { select: select, value: value, _token: _token, dependent: dependent, old_sanction_id: last_sanction_id },
              success: function(result)
              {
                $('#' + dependent).html(result);
                console.log("result", result);
                console.log("dependent", dependent);
              },
              error: function(xhr)
              {
                console.log(xhr.responseText); // Handle the error
              }
           });
     }
    });
    $('#client_id').change(function() 
    {
      $('#sanction_id').val('');
    });
    var client_id = $('#client_id').val();
    console.log("client_id", client_id);
    if(client_id != '')
    {
      $('.dynamic').trigger('change');
    }  
    
});

//calculation of pending disbursement
function calculate()
{    
  var sanction = document.getElementById('sanction_loan_amt').value;    
  var disbursement = document.getElementById('disb_amt').value; 
  var partial_disbursement = document.getElementById('disb_partial_amount').value;  
  document.getElementById('pending_disb').value = parseInt(sanction)-(parseInt(disbursement)+parseInt(partial_disbursement));     
} 

function calculateUpdate(disb_amt, last_disb_amt)
{    
  var sanction = document.getElementById('sanction_loan_amt').value;    
  var disbursement = document.getElementById('disb_amt').value; 
  var partial_disbursement = document.getElementById('disb_partial_amount').value;
  var integerValue = parseInt(disbursement);
  // console.log("disbursement", integerValue);
  // console.log("partial_disbursement", partial_disbursement);
  // console.log("last_disb_amt", last_disb_amt);
  // console.log("integerValue", $.isNumeric(integerValue));
  if($.isNumeric(integerValue))
  {    
  document.getElementById('pending_disb').value = (parseInt(sanction)) - ((parseInt(integerValue) + parseInt(partial_disbursement) - parseInt(last_disb_amt)));
  
  // var cur_disb_amt =  (parseInt(partial_disbursement) - parseInt(last_disb_amt)) + parseInt(disbursement);
    // document.getElementById('disb_partial_amount').value = cur_disb_amt;
    // $("#disb_partial_amount").val(cur_disb_amt);
  }   
}


function fetchTextFieldData(id)
{
 
  // var data1= document.getElementById('sanction_id').value;
  // alert(data1);
  // if(data1){
  //   // document.getElementById('old_sanction_id').setAttribute('selected',selected);
  //   var option = document.querySelector('#sanction_id option[value="' + data1 + '"]');
  // if (option) {
  //   option.selected = true;
  // }
  // }
  $.ajaxSetup({
    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
             });
  $.ajax({
      url: '/fetch-data/' + id,
      type: 'POST',
      
      success: function(response) 
      {
        console.log(response);
        if (response.data1.length > 0)
        {
          var latestPendingDisbursement = response.data1[response.data1.length - 1].pending_disb;
          $('#pending_disb').val(latestPendingDisbursement).addClass('readonly-textbox').attr('readonly', true);
        }
        else
        {
          $('#pending_disb').val(0).addClass('readonly-textbox').attr('readonly', true); // Display 0 as the default value
        }          
          $('#bank_name').val(response.data.bank_name).addClass('readonly-textbox').attr('readonly', true);
          $('#sanction_loan_amt').val(response.data.sanction_loan_amt).addClass('readonly-textbox').attr('readonly', true);
          $('#disb_partial_amount').val(response.data.disb_partial_amount).addClass('readonly-textbox').attr('readonly', true);              
          $('#new_sanction_id').val(response.data.sanction_id);
      },
      error: function(xhr) 
      {
          console.log(xhr.responseText);
      }
        }); 
}

//for change disbusrement status if pending amt is 0
function updateStatus()
{
    var partialDisbursement = document.getElementById("pending_disb").value;
    if (partialDisbursement == 0)
    {
      document.querySelector('option[value="Final_disbursment"]').setAttribute("selected", "selected");  
    }
    else
    {
      document.querySelector('option[value="Final_disbursment"]').setAttribute("none", "none");
    }
}

//fetch value for edit bank
function editbtn()
{ 
  
      $(document).on('click','.editbtn',function()
       {
        var b_id = $(this).val();
        //alert(b_id);
        $('#editModal').modal('show');
        
        $.ajax({
          type:"GET",
          url:"/edit-bank/"+b_id,
          success:function(response){
          $('#update_bank_name').val(response.data.bank_name);
          $('#b_id').val(b_id);
          
        }
          
               });
        });
    }



// Add bank with validation

  function storeData() {
   
    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    });
    var bank_name = $('#bank_name').val();

    $.ajax({
    url:"/addbank",
    type:'POST',
       data:{bank_name:bank_name},
    success:function(data) {
      console.log("DATA", data);
       location.reload();
     
    },
    error:function(data) {
      var errors = data.responseJSON;
      if($.isEmptyObject(errors) == false) {
        $.each(errors.errors, function(key,value){
          var errorId = '#' + key + 'Error';
          $(errorId).removeClass("d-none");
          $(errorId).text(value);

        });
      }
      }
    })
 }

// Update bank with validation
  
  function updateData() {
    
    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    });
   
    var b_name = $('#update_bank_name').val();
    var b_id = $('#b_id').val();

   $.ajax({
    url:"/update-bank",
    type:'PUT',
    data:{bank_name:b_name, b_id:b_id},
    dataType: 'json',
    success:function(data){
      console.log('Error', data);
      $('#updateForm').submit();
      console.log("DATA", data);
      location.reload(); 
      
    },
    error:function(data) {
      var errors = data.responseJSON;
      if($.isEmptyObject(errors) == false) {
        $.each(errors.errors, function(key,value){
          var errorId = '#update_bank_nameError';
          $(errorId).removeClass("d-none");
          $(errorId).text(value);

        })
      }
    }
    })
  }
  
// add comments on contact show page

function addbtnContact(contact) {
    var button = $('#cmt'); // Reference to the clicked button

    // Disable the button
    button.prop('disabled', true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var cmt = $('#cmt').val();
    var data = "text";
    $.ajax({
        type: "POST",
        url: "/addContactComment",
        dataType: "json",
        data: {
            data: data,
            cmt: cmt,
            contact: contact
        },
        success: function(response) {
            $('.list-group').css('display', 'none');
            $('div#comments-list-container').css('display', 'block');
            var commentsList = $('#comments-list');

            // Clear the contents of the comments list
            commentsList.empty();

            //Reseting textbox values after successful ajax response
            $('#cmt').val('');

            response.comments.forEach(function(comment) {
                var dateTime = new Date(comment.created_at);
                var date = dateTime.toLocaleDateString();
                var time = dateTime.toLocaleTimeString();
                var commentColor = comment.isImportant ? 'red' : 'black';
                var listItem = '<li class="commentList">' + '<br>' +
                    '<i class="fas fa-user-circle"></i>' + '   ' + comment.created_by + '' + '<br>' +
                    '<span class="comment">' + '<span class="comment" style="color: ' + commentColor + ';">' + comment.comments + '</span>' + '<br>' +
                    date + '&nbsp;&nbsp;&nbsp;&nbsp;' + time + '<br><br>' +
                    '</li><br>';

                commentsList.append(listItem);
            });

            // Enable the button after the AJAX request is completed
            button.prop('disabled', false);

            // Scroll to the bottom of the comments list
            var container = $('#comments-list-container');
            container.scrollTop(container.prop('scrollHeight'));
        },
        error: function() {
            // Enable the button if an error occurs during the AJAX request
            button.prop('disabled', false);
        }
    });
}

// add comments on sanction show page
function addbtn(sanction) {

    var button = $('#cmt'); // Reference to the clicked button

    // Disable the button
    button.prop('disabled', true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var cmt = $('#cmt').val();
    var data = "text";
    $.ajax({
        type: "POST",
        url: "/addSanctionComment",
        dataType: "json",
        data: {
            data: data,
            cmt: cmt,
            sanction: sanction
        },
        success: function(response) {
            $('.list-group').css('display', 'none');
            $('div#comments-list-container').css('display', 'block');
            var commentsList = $('#comments-list');

            // Clear the contents of the comments list
            commentsList.empty();

            //Reseting textbox values after successful ajax response
            $('#cmt').val('');

            response.comments.forEach(function(comment) {
                var dateTime = new Date(comment.created_at);
                var date = dateTime.toLocaleDateString();
                var time = dateTime.toLocaleTimeString();
                var commentColor = comment.isImportant ? 'red' : 'black';
                var listItem = '<li class="commentList">' + '<br>' +
                    '<i class="fas fa-user-circle"></i>' + '   ' + comment.created_by + '' + '<br>' +
                    '<span class="comment">' + '<span class="comment" style="color: ' + commentColor + ';">' + comment.comments + '</span>' + '<br>' +
                    date + '&nbsp;&nbsp;&nbsp;&nbsp;' + time + '<br><br>' +
                    '</li><br>';

                commentsList.append(listItem);
            });

            // Enable the button after the AJAX request is completed
            button.prop('disabled', false);

            // Scroll to the bottom of the comments list
            var container = $('#comments-list-container');
            container.scrollTop(container.prop('scrollHeight'));
        },
        error: function() {
            // Enable the button if an error occurs during the AJAX request
            button.prop('disabled', false);
        }
    });
}

//add comments on disbursement show page 
function addbtnDisb(disbursement) {

    var button = $('#cmt'); // Reference to the clicked button

    // Disable the button
    button.prop('disabled', true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var cmt = $('#cmt').val();
    var data = "text";
    $.ajax({
        type: "POST",
        url: "/addDisbursementComment",
        dataType: "json",
        data: {
            data: data,
            cmt: cmt,
            disbursement: disbursement
        },
        success: function(response) {
            $('.list-group').css('display', 'none');
            $('div#comments-list-container').css('display', 'block');
            var commentsList = $('#comments-list');

            // Clear the contents of the comments list
            commentsList.empty();

            //Reseting textbox values after successful ajax response
            $('#cmt').val('');

            response.comments.forEach(function(comment) {
                var dateTime = new Date(comment.created_at);
                var date = dateTime.toLocaleDateString();
                var time = dateTime.toLocaleTimeString();
                var commentColor = comment.isImportant ? 'red' : 'black';
                var listItem = '<li class="commentList">' + '<br>' +
                    '<i class="fas fa-user-circle"></i>' + '   ' + comment.created_by + '' + '<br>' +
                    '<span class="comment">' + '<span class="comment" style="color: ' + commentColor + ';">' + comment.comments + '</span>' + '<br>' +
                    date + '&nbsp;&nbsp;&nbsp;&nbsp;' + time + '<br><br>' +
                    '</li><br>';

                commentsList.append(listItem);
            });

            // Enable the button after the AJAX request is completed
            button.prop('disabled', false);

            // Scroll to the bottom of the comments list
            var container = $('#comments-list-container');
            container.scrollTop(container.prop('scrollHeight'));
        },
        error: function() {
            // Enable the button if an error occurs during the AJAX request
            button.prop('disabled', false);
        }
    });
}

/* leade source SM */
function onLeadSourceSM(sourceVal) {
    console.log("sourceVal this", jQuery("#lead_source_sm").val());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "/getLeadSourceTL",
        dataType: "json",
        data: {
            data: sourceVal
        },
        success: function(response) {
            var dropdown = $('#lead_source_TL');
            dropdown.empty();
            response.data.forEach(function(responseData) {
                var optionElement = $('<option></option>').attr('value', responseData.team_leader_name).text(responseData.team_leader_name);
                dropdown.append(optionElement);
            });

            console.log("sourceVal response", response);
        },

    });

};

function updateSM(sourceVal) {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "/getLeadSourceTL",
        dataType: "json",
        data: {
            data: sourceVal

        },
        success: function(response) {
            // console.log(response);
            var dropdown = $('#up_lead_source_TL');
            dropdown.empty();
            response.data.forEach(function(responseData) {
                var optionElement = $('<option></option>').attr('value', responseData.team_leader_name).text(responseData.team_leader_name);
                dropdown.append(optionElement);
            });
            console.log("sourceVal response", response);
        },

    });

}

function onLeadSourceTL(lead_sourceTL)
{
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
	type: "POST",
	url: "/getLeadSourceTLTeam",
	dataType: "json",
	data: {
	    data: lead_sourceTL
	},
	success: function(response) {

            var dropdown = $('#lead_source_sm');
            dropdown.empty();
            response.data.forEach(function(resData) {
             var optionElement = $('<option></option>').attr('value', resData.firstname +" "+ resData.lastname).text(resData.firstname +" "+ resData.lastname);
              dropdown.append(optionElement);
          });

    }
  });

}

/*Update lead source SM */
function updateTL(lead_sourceTL)
{

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
        type: "POST",
        url: "/getLeadSourceTLTeam",
        dataType: "json",
        data: {
            data: {lead_source_sm:lead_sourceTL}
        },
        success: function(response) {

            var dropdown = $('#up_lead_source_sm');
            dropdown.empty();
            response.data.forEach(function(resData) {
                var optionElement = $('<option></option>').attr('value', resData.firstname + " " + resData.lastname).text(resData.firstname + " " + resData.lastname);
                dropdown.append(optionElement);
                // dropdown.trigger('change');
            });

        }
    });
}

// Modal for disbursement tab

function addDisbursement(formData)
{
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var formData = new FormData($('#disbForm')[0]);

  $.ajax({
    type: "POST",
    url: "/disbursements",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response)
    {
      if(response.success) {
         var message = response.message;
         $('#message').text(message).show();
         var messageError = response.message;
         $('#messageError').text(messageError).hide();
         swal({
          title: "Success!",
          text:  "Disbursement Data Successfully Added!",
          type: "success",
          timer: 2000,
          // showConfirmButton: false
        }).then(() => {
          $('#disbmodal').modal('hide');
            $('.modal-backdrop').remove();
            location.reload();
        });
      }else {
         var messageError = response.message;
         $('#messageError').text(messageError).show();
         var message = response.message;
         $('#message').text(message).hide();
      }

      clearModalErrors();      
    },
    error: function(xhr, status, error) 
    {
   
      if (xhr.status === 422) 
      {      
        var errors = xhr.responseJSON.errors;
        clearModalErrors();
       
          for (var field in errors) {
            if (errors.hasOwnProperty(field)) {
                var errorContainer = $('#' + field + 'ErrorContainer');
                errorContainer.text(errors[field][0]);
            }
        }
        
      }
      else
      {
         console.error(xhr.responseText);
      }
    }
  });
}
function clearModalErrors() 
{
  $('.error-container').empty();
}


 // add sanction modal on contact show page

function storeSanctionData(formData)
{
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
 
  var formData = new FormData($('#sanctionForm')[0]);

  $.ajax({
    type: "POST",
    url: "/sanction",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response)
    {
      if (response.success) {
        var successMessage = response.message;
        $('#successMessage').text(successMessage).show();
        var errorMessage = response.message;
        $('#errorMessage').text(errorMessage).hide();

        swal({
          title: "Success!",
          text:  "Sanction Data Successfully Added!",
          type: "success",
          timer: 2000,
          // showConfirmButton: false
        }).then(() => {
          $('#sanctionModal').modal('hide');
            $('.modal-backdrop').remove();
            location.reload();
        });
    
      }
      else{
        var successMessage = response.message;
        $('#successMessage').text(successMessage).hide();
        var errorMessage = response.message;
        $('#errorMessage').text(errorMessage).show();
      }
     
      clearErrors();
    },
    error: function(xhr, status, error) 
    {
      console.log('error',error);
      if (xhr.status === 422) 
      {      
        var errors = xhr.responseJSON.errors;
        clearErrors();        
       
          for (var field in errors) {
            if (errors.hasOwnProperty(field)) {
                var errorContainer = $('#' + field + 'Error');
                errorContainer.text(errors[field][0]);
            }
        }
        
      }
      else
      {
         console.error(xhr.responseText);
      }
    }
  });
}
function clearErrors() {
  $('.error-container').empty();
}


