$(document).ready(function () {

    var pa = $('#user-11');
    var pb = $('#user-16');
    var positiona = pa.position();
    var positionb = pb.position();
    console.log(positiona.top + ' ' + positiona.left);
    console.log(positionb.top + ' ' + positionb.left);

    var lineData = [{"x": positiona.top, "y": positiona.left}, {"x": positionb.top, "y": positionb.left}];

    //This is the accessor function we talked about above
    var lineFunction = d3.svg.line()
        .x(function (d) {
            return d.x;
        })
        .y(function (d) {
            return d.y;
        })
        .interpolate("linear");

    //The SVG Container
    var svgContainer = d3.select("body").append("svg")
        .attr("style", "position:fixed; top:0; bottom:0; left:0; right:0");

    //The line SVG Path we draw
    var lineGraph = svgContainer.append("path")
        .attr("d", lineFunction(lineData))
        .attr("stroke", "blue")
        .attr("stroke-width", 2)
        .attr("fill", "none");
});