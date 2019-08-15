var context;
var rightKey = false;
var leftKey = false;
var upKey = false;
var downKey = false;
var character_x;
var character_y;
var character_h = 42;
var character_w = 42;

function init() {
  //canvas = document.getElementById('canvas');
  context = $('#xcanvas')[0].getContext('2d');
  context.canvas.width = window.innerWidth;
  context.canvas.height = window.innerHeight ;
  WIDTH = window.innerWidth;
  HEIGHT = window.innerHeight;
  character_x = WIDTH / 2 - 15;
  character_y = HEIGHT /2 - 15;
  setInterval('draw()', 25);
}
function clearCanvas() {
  context.clearRect(0,0,WIDTH,HEIGHT);
}

function rect(x,y,w,h) {
  context.beginPath();
  context.rect(x,y,w,h);
  context.endPath();
}

function draw() {
  clearCanvas();
  if (rightKey) character_x += 5;
  else if (leftKey) character_x -= 5;
  if (upKey) character_y -= 5;
  else if (downKey) character_y += 5;
  if (character_x <= 0) character_x = 0;
  if ((character_x + character_w) >= WIDTH) character_x = WIDTH - character_w;
  if (character_y <= 0) character_y = 0;
  if ((character_y + character_h) >= HEIGHT) character_y = HEIGHT - character_h;
  context.fillRect(character_x,character_y,character_w,character_h);
}

function onKeyDown(evt) {
  if (evt.keyCode == 39) rightKey = true;
  // do post + 1 column
  // change character animation to right view walking
  else if (evt.keyCode == 37) leftKey = true;
  // do post - 1 column
  // change character animation to left view walking
  if (evt.keyCode == 38) upKey = true;
  // do post + 1 row
  // change character animation to up view walking
  else if (evt.keyCode == 40) downKey = true;
  // do post - 1 row
  // change character animation to down view walking
}

function onKeyUp(evt) {
  if (evt.keyCode == 39) rightKey = false;
  // change character to right view NOT walking
  else if (evt.keyCode == 37) leftKey = false;
  // change character to left view NOT walking
  if (evt.keyCode == 38) upKey = false;
  // change character animation to up view NOT walking
  else if (evt.keyCode == 40) downKey = false;
  // change character animation to down view NOT walking
}

$(document).keydown(onKeyDown);
$(document).keyup(onKeyUp);