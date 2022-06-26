<style>
    html, body {
        padding: 0;
        margin: 0;
        font-family: Verdana, "sans-serif";
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #eaeaea;
    }

    nav {
        background-color: white;
        display: flex;
        height: 3em;
        padding: 0.5em;
        align-items: stretch;
        justify-content: space-between;
    }

    nav .nav_button {
        height: 100%;
        display: flex;
    }

    form .button {
        height: 100%;
    }

    .button {
        padding: 0.8em;
        /*height: 100%;*/
        background-color: darkgrey;
        border-radius: 3px;
        border: solid 1px black;
        text-decoration: none;
        color: white;
        font-size: 1em;
    }

    .button:hover {
        background-color: #8f8f8f;
        cursor: pointer;
    }

    .wrapper {
        padding: 0 1em;
        /*max-width: 1200px;*/
        margin: 0 auto 1em;
    }

    .form {
        display: flex;
        flex-direction: column;
        width: fit-content;
        align-items: flex-end;
        margin: auto;
    }

    .coin_info {
        border-radius: 10px;
        border: solid 1px black;
        background-color: white;
        padding: 0 1em 1em;
        margin-top: 1em;
    }

    form label {
        margin: 5px 0;
    }

    footer {
        margin-top: auto;
        background: #c4c4c4;
        padding: 1em;
    }

    .text-center {
        text-align: center;
    }

    .warning {
        color: red;
    }

    .coins {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .coin {
        padding: 0 1em;
        margin: 0.5em;
        border-radius: 10px;
        border: solid 1px black;
        background-color: white;
        width: fit-content;
    }


</style>