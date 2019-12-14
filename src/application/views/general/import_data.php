<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Importing, please wait</title>

<style>
body {
  margin: 0;
  overflow: hidden;
  cursor: pointer;
}
</style>

</head>
<body bgcolor = '#b1e4e2'>

<h1>
<?php echo $success ? 'Successfully!!!!!!!!  ' : 'Failed!!!!!!!!!  ' ?>
<a href="/courschemaster/src/index.php" style="text-decoration:none;color:#fff;background-color: #ff007f;padding:20px;">
back to home page
</a>
</h1>

<h1>
<?php echo $success ? '' : $exception; ?>
</h1>

<canvas id="canvasID"></canvas>

<script>
const canvas = document.querySelector('canvas');
const c = canvas.getContext('2d');
canvas.width = innerWidth;
canvas.height = innerHeight;

// Variables
const mouse = {
	x: innerWidth / 2,
	y: innerHeight / 2 - 90
};

const colors = [
	'#ee3d2b',
	'#ec5252',
	'#ff007f',
  '#ec5252',
];

// Event Listeners
addEventListener('mousemove', event => {
	mouse.x = event.clientX;
	mouse.y = event.clientY;
});

addEventListener('resize', () => {
	canvas.width = innerWidth;
	canvas.height = innerHeight;
	init();
});

function randomIntFromRange(min,max) {
	return Math.floor(Math.random() * (max - min + 1) + min);
}

function randomColor(colors) {
	return colors[Math.floor(Math.random() * colors.length)];
}

function Particle(x, y, radius, color) {
	const distance = randomIntFromRange(0, 190);
	this.x = x;
	this.y = y;
	this.radius = radius;
	this.color = color;
	this.radians = Math.random() * Math.PI * 2;
	this.velocity = 0.08;
	this.distanceFromCenter = {
		x: distance,
		y: distance
	};
	this.prevDistanceFromCenter = {
		x: distance,
		y: distance
	};
	this.lastMouse = {x: x, y: y};

	this.update = () => {
		const lastPoint = {x: this.x, y: this.y};
		this.radians += this.velocity;
		this.lastMouse.x += (mouse.x -     this.lastMouse.x) * 0.05;
		this.lastMouse.y += (mouse.y - this.lastMouse.y) * 0.05;

		// Circular Motion
		this.distanceFromCenter.x = this.prevDistanceFromCenter.x + Math.sin(this.radians) * 270;
		this.distanceFromCenter.y = this.prevDistanceFromCenter.x + Math.sin(this.radians) * 60;

		this.x = this.lastMouse.x + Math.cos(this.radians) * this.distanceFromCenter.x;
		this.y = this.lastMouse.y + Math.sin(this.radians) * this.distanceFromCenter.y;

		this.draw(lastPoint);
	};

	this.draw = lastPoint => {
		c.beginPath();
		c.strokeStyle = this.color;
		c.lineWidth = this.radius;
		c.moveTo(lastPoint.x, lastPoint.y);
		c.lineTo(this.x, this.y);
		c.stroke();
		c.closePath();
	};
}

let particles;
function init() {
	particles = [];

	for (let i = 0; i < 550; i++) {
		const radius = (Math.random() * 2) + 1;
		particles.push(new Particle(canvas.width / 2, canvas.height / 2, radius, randomColor(colors)));
	}
}

function animate() {
	requestAnimationFrame(animate);
	c.fillStyle = "#b1e4e2";
  c.fillRect(0, 0, canvas.width,    canvas.height);

	particles.forEach(particle => {
		particle.update();
	});
}

init();
animate();
</script>

</body>
</html>
