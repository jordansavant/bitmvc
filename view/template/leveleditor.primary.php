<html>
<head>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery.qtip.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/qtip.css" />
<style>
body {
    background-color: #272727;
    color: #FFF;
    font-family: 'Trebuchet MS';
    font-size: 16px;
}
pre {
    font-family: 'Courier New';
    font-size: 12px;
}
input[type="submit"],
input[type="button"],
a {
    color: #BEEC2B;
    text-decoration: none;
    border: 1px solid;
    padding-left: 4px;
    border-radius: 5px;
    padding-right: 4px;
    font-size: 12px;
    background: none;
}
input[type="submit"]:active,
input[type="button"]:active,
a:active {
    color: #EC882B;
}
h1 {
    font-size: 1.4em;
}
li {
    margin-bottom: 10px;
    list-style-type: square;
}
label.formLabel
{
    min-width: 110px;
    display: inline-block;
    border-bottom: 1px solid;
}
table.map
{
    border: 0px;
    border-spacing: 7px;
}
table.map td
{
    padding: 0px;
    border: 0px;
    width: 30px;
    height: 30px;
}
table.map .cell
{
    cursor: pointer;
}
table.map td.notile
{
    border-radius: 50px;
    background: #000;
}
table.map td.tile
{
    background: #000;
}
table.map .structure
{
    width: 20px;
    height: 20px;
    margin: 5px;
    border-radius: 4px;
    background-color: #999;
}
</style>
</head>
<body>

<div>
<a href="index.php?c=<?=$C?>&o=index">Index</a>
##breadcrumb##
</div>
<hr />
##header##
##content##

</body>
