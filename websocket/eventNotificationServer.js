var webSocketServer = require("websocket").server;
var http = require("http");
var htmlEntity = require("html-entities");
var PORT = 3280;

// List of currently connected clients (users)
var clients = [];

// Create a server

var server = http.createServer();

server.listen(PORT, function () {
    console.log("(jc)-> Server is listening on port :" + PORT);
});

// Create the web socket servers heres
wsServer = new webSocketServer({
    httpServer: server,
});

/**
 *The web socket server
 */

wsServer.on("request", function (request) {
    var connection = request.accept(null, request.origin);

    //indexin 0 dan başlaması lazım
    // pass each connection instance to each client
    var index = clients.push(connection) - 1;

    console.log("Client", index, "connected");

    /**
     * This is where the send message to all the clients connected
     */
    connection.on("message", function (message) {
        console.log(message);
    });

    /**
     * When the client closes its connection to the web socket server
     */

    connection.on("close", function (connection) {
        clients.splice(index, 1);
        console.log("Client ", index, "was disconnected");
    });
});
