var socket  = require( 'socket.io' );
var requestify = require('requestify');
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;


    // app.set('port', process.env.PORT || 3000);
    // app.set('views', __dirname + '/views');
    // app.set('view engine', 'jade');
    // app.use(express.logger('dev'));
    // app.use(express.bodyParser());
    // app.use(express.methodOverride());
    // app.use(app.router);
    // app.use(express.static(path.join(__dirname, 'public')));

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


var mysql = require('mysql');
var connectionsArray    = [],
        db         = mysql.createConnection({
        host        : 'localhost',
        user        : 'root',
        password    : 'Webhaus#_12',
        database    : 'shiftmate',
        port        : 3306
    }),
    POLLING_INTERVAL = 1000,
    pollingTimer,
    clients={},
    clientsIds = [],
    orgs = {},
    orgIds = [];


db.connect(function(err){
if(!err) {
    console.log("Database is connected.");
} else {
    console.log("Error connecting database.");   
}
});

var pollingReviewNotification = function(){

    var today = getTodayDate();

    var query = db.query('SELECT id,organization_id FROM  `organization_users` WHERE  DATEDIFF(reviewdate,"'+today+'") = 1 AND reviewnotification = 0');

    var reviewLists = [];
    query
    .on('error', function(err) {
        // Handle error, and 'end' event will be emitted after this as well
        console.log( err );

        
    })
    .on('result', function( reviews ) {

        // console.log(reviews);
        reviewLists.push(reviews);
    })
    .on('end',function(){
        if(connectionsArray.length) {
            setTimeout( pollingReviewNotification, POLLING_INTERVAL );

            updateReviewNotification(reviewLists);
        }
    });
}

var pollingLiscenseExpNotif = function(){

    var today = getTodayDate();

    var query = db.query('SELECT id,user_id FROM  `liscenses` WHERE  DATEDIFF(expirydate,"'+today+'") = 1 AND useenstatus = 0');

    var list = [];
    query
    .on('error', function(err) {
        // Handle error, and 'end' event will be emitted after this as well
        console.log( err );
    })
    .on('result', function( data ) {

        list.push(data);
    })
    .on('end',function(){
        if(connectionsArray.length) {
            setTimeout( pollingLiscenseExpNotif, POLLING_INTERVAL );

            updateLiscenseExpNotif(list);
        }
    });
}

var pollingMessageNotification = function(){

    // console.log(clientsIds);
    var clIds = clientsIds.join();

    // console.log(clIds);
    var query = db.query('SELECT * FROM receivers WHERE status = 0 AND user_id IN ('+clIds+')');

    var messageList = [];
    query
    .on('error', function(err) {
        // Handle error, and 'end' event will be emitted after this as well
        console.log( err );

        
    })
    .on('result', function( messages ) {

        // console.log(messages);
        messageList.push(messages);
    })
    .on('end',function(){
        if(connectionsArray.length) {
            setTimeout( pollingMessageNotification, POLLING_INTERVAL );

            updateMsgNotification(messageList);
        }
    });
}

var pollingLoop = function () {

    var today = getTodayDate();


    var query = db.query('SELECT * FROM shift_users WHERE status = 1 AND shift_date >= "'+today+'" AND shiftassignnotification= 0');

    // console.log(query);
    var users = []; // this array will contain the result of our db query


    // set up the query listeners
    query
    .on('error', function(err) {
        // Handle error, and 'end' event will be emitted after this as well
        console.log( err );
        updateSockets( err );
        
    })
    .on('result', function( shifts ) {
        // console.log(shifts);

        // it fills our array looping on each user row inside the db
        users.push( shifts );
        // console.log(users);
    })
    .on('end',function(){
        // loop on itself only if there are sockets still connected
        if(connectionsArray.length) {
            pollingTimer = setTimeout( pollingLoop, POLLING_INTERVAL );

            updateSockets({users:users});
        }
    });

};

var shiftRequestResponseNotifLoop = function()
{
    

    var query = db.query('SELECT * FROM shift_users WHERE status = 3 AND managernotifications = 0');

    // console.log(query);
    var shifts = []; // this array will contain the result of our db query

    // set up the query listeners
    query
    .on('error', function(err) {
        // Handle error, and 'end' event will be emitted after this as well
        console.log( err );
        updateSockets( err );
        
    })
    .on('result', function( shift ) {
        // it fills our array looping on each user row inside the db
        shifts.push( shift );
        // console.log(users);
    })
    .on('end',function(){
        // loop on itself only if there are sockets still connected
        if(connectionsArray.length) {
            setTimeout( shiftRequestResponseNotifLoop, POLLING_INTERVAL );

            updateManagerNotifi({users:shifts});
        }
    });
}

// create a new websocket connection to keep the content updated without any AJAX request
io.sockets.on( 'connection', function ( socket ) {

    console.log('user connected');
    // console.log(socket);
    // console.log(socket.handshake.query.orgId);

    if(socket.handshake.query.orgId != 0)
    {
        orgs[socket.handshake.query.orgId] = socket;
        
    }
    if(orgIds.indexOf(socket.handshake.query.orgId) == -1)
    {
        orgIds.push(socket.handshake.query.orgId);
    }


    pollingReviewNotification();

    clients[socket.handshake.query.userId] = socket;

    if(clientsIds.indexOf(socket.handshake.query.userId) == -1)
    {
        clientsIds.push(socket.handshake.query.userId);
    }
    // console.log(clientsIds);

    console.log('Number of connections:' + connectionsArray.length);
    // start the polling loop only if at least there is one user connected
    if (!connectionsArray.length) {
        pollingLoop();
        pollingMessageNotification();
        pollingLiscenseExpNotif();
    }

    socket.on('shiftRequestResponseNotif', function(user)
        {            
            clients[user.userId].boardIds = user.boardManagerList;
            // console.log(clients);
            shiftRequestResponseNotifLoop();
        });

    
    socket.on('disconnect', function () {

        var userId = this.handshake.query.userId;
        var orgId = this.handshake.query.orgId;

        // delete clients[userId];
        // clientsIds.splice(clientsIds.indexOf(userId), 1);

        // if(orgId != 0)
        // {
        //     delete orgs[orgId];
        //     orgIds.splice(orgIds.indexOf(orgId), 1);
        // }

        // console.log(orgs);

        var socketIndex = connectionsArray.indexOf( socket );
        console.log('socket = ' + socketIndex + ' disconnected');
        if (socketIndex >= 0) {
            connectionsArray.splice( socketIndex, 1 );
        }
    });

    console.log( 'A new socket is connected!' );
    connectionsArray.push( socket );
    
});


var updateManagerNotifi = function(data)
{
    data.time = new Date();
    // send new data to all the sockets connected

    data.users.forEach(function(i)
        {
            var url = 'http://localhost/shiftmate_api_test/BoardUsers/getBoardManager/'+i.board_id+'.json';
            requestify.get(url)
              .then(function(response) {
                  // Get the response body (JSON parsed or jQuery object for XMLs)
                  // console.log(response.body);
                  var jsonData = response.body;

                  var obj = JSON.parse( jsonData );
                  // console.log(obj.BoardUser.user_id);

                    if(clients[obj.BoardUser.user_id] != undefined)
                    {
                        var userSoc = clients[obj.BoardUser.user_id];

                        userSoc.emit( 'managerShiftRespNoti' , i );
                    }
              }
            );

        });

};

var updateMsgNotification = function(data)
{
    // console.log(data);
    data.time = new Date();
    // send new data to all the sockets connected

    data.forEach(function(i)
        {
            if(clients[i.user_id] != undefined)
            {
                var userSoc = clients[i.user_id];
                
                userSoc.emit( 'updateMsgNotification' , i );
            }
        });
};

var updateReviewNotification = function(data)
{
    // data.time = new Date();
    data.forEach(function(i){
        if(orgs[i.organization_id] != undefined)
        {
            var userSoc = orgs[i.organization_id];
            userSoc.emit( 'updateReviewNotification' , i );
        }
    });
};

var updateLiscenseExpNotif = function(data)
{
    // data.time = new Date();
    data.forEach(function(i){
        if(clients[i.user_id] != undefined)
        {
            var userSoc = clients[i.user_id];
            userSoc.emit( 'updateLiscExpNotification' , i );
        }
    });
};

var updateSockets = function ( data ) {

    // console.log(data.users);
    // store the time of the latest update
    data.time = new Date();
    // send new data to all the sockets connected
    connectionsArray.forEach(function( tmpSocket ){

        data.users.forEach(function(i)
            {
                if(clients[i.user_id] != undefined)
                {
                    var userSoc = clients[i.user_id];

                    userSoc.emit( 'shiftRequestNotification' , i );
                }
            });
    });
};


var getTodayDate = function()
{
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    } 
    if(mm<10){
        mm='0'+mm;
    } 

    var today = yyyy+'-'+mm+'-'+dd;

    return today;
};