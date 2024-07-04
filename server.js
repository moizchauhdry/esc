var app = require('express')();
var http = require('http').Server(app);
var fs = require('fs');
// var http = require('https').createServer({ key: fs.readFileSync("/home/admin/ssl/keys/c7ac0_54f1f_283916dc7a9e2efe668f014fcaa554d9.key"), cert: fs.readFileSync("/home/admin/ssl/certs/manage_bizmodo_io_c7ac0_54f1f_1727740799_e6713678743481f717da5ba2154abe64.crt") }, app);

var io = require('socket.io')(http, {
    cors: {
        origin: '*'
    }
});

// var io = require('socket.io')(http, {
//     cors: {
//         origin: '*'
//     }
// });

var Redis = require('ioredis');
var redis = new Redis();

var users = [];

http.listen(8006, function () {
    console.log('Listening to port 8006');
});

redis.subscribe('private-channel', function () {
    console.log('Subscribed to private-channel.io');
});

redis.on('message', function (channel, message) {
    console.log(message , channel);
    // message = JSON.parse(message);
    // if (channel == 'private-channel') {
    //     let data = message.data.data;
    //     let receiver_id = data.receiver_id;
    //     let event = message.event;
    //     io.emit(channel + ':' + message.event, data);
    // }
});

var all_user = {};
io.on('connection', function (socket) {
    socket.on('user_connected', function (user_id) {
        users[user_id] = socket.id;
        all_user[socket.id] = user_id;
        io.emit('userUpdateStatus', all_user);
        // console.log(all_user);
    });
    socket.on('disconnect', function (user_id) {
        var i = users.indexOf(socket.id);
        delete all_user[socket.id];
        users.splice(i, 1, 0);
        io.emit('userUpdateStatus', all_user);
    });
});