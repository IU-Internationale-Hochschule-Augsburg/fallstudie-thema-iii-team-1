const http = require('http');

// Sample data
const jsonData = {
    name: "John Doe",
    age: 30
};

// Create HTTP server
const server = http.createServer((req, res) => {  //Hier wird der HTTP Server erstellt
    // Set CORS headers
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Request-Method', '*');
    res.setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET'); // Sie sagen dem Browser, dass Anfragen von jedem Ursprung (*) erlaubt sind, und erlauben alle Methoden (*) und Header (*). 
    res.setHeader('Access-Control-Allow-Headers', '*');            // Dies ermöglicht es Client-Anwendungen, Ressourcen von diesem Server abzurufen, selbst wenn sie von verschiedenen Ursprüngen stammen.
    if (req.method === 'OPTIONS') { //Behandeln von Options Anfragen 
        res.writeHead(200);
        res.end();
        return;
    }

    // Serve JSON data
    if (req.url === '/data') {
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(jsonData));
    } else {
        res.writeHead(404);
        res.end('Not Found');
    }
});

// Start server
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});