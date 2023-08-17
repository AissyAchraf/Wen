// API JS


// Hotels Api

function deletePhotoFromHotel(hotel_id, image_name) {
    $.ajax(
    {
        url: '/api/hotel/deletePhotoFromHotel/'+hotel_id+'/'+image_name,
        type: 'put',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

function updateHotel(hotel_id) {
    $.ajax(
    {
        url: '/api/hotel/updateHotel/'+hotel_id,
        type: 'put',
        dataType: "JSON",
        data: $("#hotelForm").serialize(),
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

// Rooms

function deletePhotoFromRoom(room_id, image_name) {
    $.ajax(
    {
        url: '/api/room/deletePhotoFromRoom/'+room_id+'/'+image_name,
        type: 'put',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

function deleteRoom(room_id) {
    $.ajax(
    {
        url: '/api/room/deleteRoom/'+room_id,
        type: 'delete',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

// Chalets

function deletePhotoFromChalet(chalet_id, image_name) {
    $.ajax(
    {
        url: '/api/chalet/deletePhotoFromChalet/'+chalet_id+'/'+image_name,
        type: 'put',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

// Restaurants

function deletePhotoFromRestaurant(Restaurant_id, image_name) {
    $.ajax(
    {
        url: '/api/restaurent/deletePhotoFromRestaurent/'+Restaurant_id+'/'+image_name,
        type: 'put',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

// Tables

function deletePhotoFromTable(Table_id, image_name) {
    $.ajax(
    {
        url: '/api/table/deletePhotoFromTable/'+Table_id+'/'+image_name,
        type: 'put',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}

function deleteTable(table_id) {
    $.ajax(
    {
        url: '/api/table/deleteTable/'+table_id,
        type: 'delete',
        dataType: "JSON",
        success: function (response)
        {
            $("#successMessage").empty().html(response.data);
            $("#successModal").modal('show');
            location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $("#failedMessage").empty().html(response.message);
            $("#failedModal").modal('show');
        }
    });
}