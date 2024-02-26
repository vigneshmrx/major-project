<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');

    #show-full-details-content-area-pdf-page {
        font-family: "Roboto Mono";
        padding: 10px;
        width: 100%;
        margin: auto;
        font-size: 12px;
    }

    #full-details-pg-heading {
        font-size: 30px;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 20px;
        text-decoration: underline;
    }

    #full-details-table {
        width: 100%;
        margin: auto;
        text-align: center;
        background-color: var(--main-white);
        border: 2px solid;
        box-shadow: 11px 11px #6610f2;
    }

    #full-details-table td,
    th {
        /* border: 1px solid; */
        padding: 10px;
    }

    #full-details-table td {
        /* border-right: 1px solid;
    border-left: 1px solid; */
        border-bottom: 1px solid;
    }

    #full-details-table th {
        background-color: #000;
        color: #fff;
        text-transform: uppercase;
        font-weight: normal;
    }

    #full-details-table tr {
        border-bottom: 2px solid;
    } 

    /* #full-details-table tr > td:nth-child(1),
    #full-details-table tr > td:nth-child(3),
    #full-details-table tr > td:nth-child(5), {
        width: 10%;
    }

    #full-details-table tr > td:nth-child(2) {
        width: 20%;
    }

    #full-details-table tr > td:nth-child(4) {
        width: 50%;
    } */

    .ten {
        width: 10%;
    }

    .fifteen {
        width: 15%;
    }

    .forty {
        width: 40%;
    }
    </style>
</head>

<body>
    <div id="show-full-details-content-area-pdf-page">
    </div>
    <script src="./js/common-script.js"></script>
</body>

</html>