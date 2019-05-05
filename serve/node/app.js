const { createServer } = require('http');
const { createSecureServer } = require('http2');
const fs = require('fs');
const port = process.env.PORT || 80;
const port_ssl = process.env.PORT_SSL || 443;
const map = {
	'.html': 'text/html',
	'.css': 'text/css',
	'.json': 'application/json',
	'.js': 'application/javascript',
	'.png': 'image/png',
	'.jpg': 'image/jpeg',
	'.ico': 'image/x-icon',
	'.svg': 'image/svg+xml',
	'.wav': 'audio/wav',
	'.mp3': 'audio/mpeg',
	'.ogg': 'audio/ogg'
};
createServer((req, res) => res.writeHead(301, {'Location': `https://${req.headers.host}${req.url}`}) || res.end()).listen(port);
const server = createSecureServer(
	{
		cert: fs.readFileSync('./localhost.crt'),
		key: fs.readFileSync('./localhost.key')
	},
	onRequest
).listen(port_ssl);
console.log(`Servers listening on ports ${port}(HTTP) / ${port_ssl}(HTTPS)`);

function onRequest({url, headers}, res) {
	url = url.substr(1).replace("..", "");
	if(!url) url = "index";
	if(!url.startsWith("static/")) {
		
		const lang = headers["accept-language"]
			.split(/\s*,\s*/)
			.map(v => v.split(/\s*;\s*q=/))
			.sort((a, b) => (b[1] || .86) - (a[1] || .86))
			.find(v => fs.statSync(v[0]).isDirectory());
		url = `${lang[0].substr(0, 2)}\/${url}.html`;
	}
	const pathname = `./${url}`;
	const [, ext] = pathname.match(/.*(\.\w+)$/);
	fs.exists(pathname, exist => {
		if(!exist || fs.statSync(pathname).isDirectory()) {
			res.statusCode = 404;
			res.end(`<h1>Error 404: Not found</h1>`);
			return;
		}
		const stream = fs.createReadStream(pathname);
		res.setHeader('Content-type', map[ext] || 'text/plain');
		if(ext === ".js") res.setHeader('Service-Worker-Allowed', '/');
		stream.pipe(res);
		stream.on("error", err => {
			console.error(err);
			res.statusCode = 500;
		});
		stream.on("end", () => res.end());
	});
}