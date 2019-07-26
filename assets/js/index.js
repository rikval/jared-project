var $concerts = $('#concerts_list');
$(function () {
    $.ajax({
        type: "GET",
        url: "/api/events.json?isPublic=true",
        success: function (data) {
            $.each(data, function (i, event) {
                console.log(data);
                // $concerts.append('<td>date: '+ event.venue.name +' </td>')
                $concerts.append('<div class="card col-4" style="width: 18rem;">' +
                    '<img class="card-img-top" src="https://source.unsplash.com/random/286x180" alt="Card image cap">' +
                    '<div class="card-body">' +
                    '<h5 class="card-title">' + event.venue.name + '</h5>' +
                    '<p class="card-text">' + event.dateEvent + '</p>' +
                    '<a href="/event/show/'+ event.id +'" class="btn btn-primary">See event</a>' +
                    '</div>' +
                    '</div>')
            })
        }
    });
});
