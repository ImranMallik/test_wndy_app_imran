<style>
    .header {
        background-color: #fff;
    }

    /*========================================================================
5. Demo Layout Two
=========================================================================*/
    .f-title {
        margin-bottom: 15px !important;
        font-size: 20px !important;
        font-weight: 500 !important;
    }

    /* {
    min-height: 100vh;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
} */

    /* @media only screen and (max-width: 991px) {
     {
        padding: 15px;
    }
} */

    .fxt-checkbox-area {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-bottom: 40px;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }

    .fxt-bg-color {
        background-color: #ffffff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 0;
    }

    .fxt-bg-img {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        margin: 0;
        padding: 0;
    }

    .fxt-content {
        padding: 100px 65px 70px 80px;
        width: 100%;
        -webkit-box-shadow: 3px 0 79px 0 rgba(0, 0, 0, 0.08);
        box-shadow: 3px 0 79px 0 rgba(0, 0, 0, 0.08);
        background-color: #ffffff;
    }

    @media only screen and (max-width: 767px) {
        .fxt-content {
            padding: 450px 10px 10px 10px !important;
            width: 100%;
            -webkit-box-shadow: none;
            box-shadow: none;
            background-color: #ffffff;
        }

        .ph-num {
            display: none;
        }

        .modal-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0;
        }

        .header {
            background-color: #f7fbfa;
        }

        .header.is-fixed {
            background-color: #f7fbfa;
        }

        body {
            background-color: #ffffff;
        }

        .fxt-logo {
            margin-bottom: 50px !important;
        }
    }

    @media only screen and (max-width: 1199px) {
        .fxt-content {
            padding: 100px 35px 70px 50px;
        }
    }

    @media only screen and (max-width: 991px) {
        .fxt-content {
            padding: 100px 70px 70px 70px;
        }
    }

    @media only screen and (max-width: 767px) {
        .fxt-content {
            padding: 380px 50px 50px 50px;
        }
    }

    @media only screen and (max-width: 575px) {
        .fxt-content {
            padding: 60px 30px 30px 30px;
        }
    }

    @media only screen and (max-width: 479px) {
        .fxt-content {
            padding: 50px 20px 20px 20px;
        }
    }

    .fxt-header {
        text-align: center;
    }

    .fxt-logo {
        display: block;
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
        max-width: 10vw;
    }

    .fxt-form .fxt-otp-logo {
        margin-bottom: 20px;
        display: block;
    }

    .fxt-form h2 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .fxt-form p {
        margin-bottom: 30px;
        font-size: 17px;
    }

    .fxt-form p span {
        display: block;
    }

    .fxt-form label {
        /* margin-top: 10px; */
        font-size: 16px;
        font-weight: 500;
    }

    .fxt-form .form-group {
        position: relative;
        z-index: 1;
        margin-bottom: 15px;
    }

    .fxt-form .form-control {
        min-height: 45px;
        -webkit-box-shadow: none;
        box-shadow: none;
        border: 1px solid #e7e7e7;
        padding: 10px 15px;
        color: #111111;
        background-color: #ffffff;
    }

    .fxt-form input::-webkit-input-placeholder {
        color: #a1a1a1;
        font-size: 15px;
        font-weight: 300;
    }

    .fxt-form input::-moz-placeholder {
        color: #a1a1a1;
        font-size: 15px;
        font-weight: 300;
    }

    .fxt-form input:-moz-placeholder {
        color: #a1a1a1;
        font-size: 15px;
        font-weight: 300;
    }

    .fxt-form input:-ms-input-placeholder {
        color: #a1a1a1;
        font-size: 15px;
        font-weight: 300;
    }

    .fxt-form .fxt-form-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .fxt-form .fxt-form-row .fxt-form-col {

        margin-right: 10px;
        flex-basis: 0;
        flex-grow: 1;
    }

    .fxt-form .fxt-form-row .fxt-form-col:last-child {
        margin-right: 0;
    }

    .fxt-form .fxt-form-btn {
        margin-bottom: 20px;
    }

    .fxt-btn-fill {
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        display: inline-block;
        font-size: 15px;
        font-weight: 500;
        -webkit-box-shadow: none;
        box-shadow: none;
        outline: none;
        border: 0;
        color: #fff;
        border-radius: 3px;
        background-color: #0571ae;
        padding: 10px 36px;
        margin-bottom: 10px;
        width: 100%;
        -webkit-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .fxt-btn-fill:hover {
        background-color: #011423;
        border-color: #da0000;
    }

    .fxt-btn-fill:focus {
        outline: none;
    }

    .switcher-text {
        color: #63bbff;
        font-size: 15px;
        margin-bottom: 5px;
        display: block;
        -webkit-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .switcher-text:hover {
        color: #000000;
    }

    .switcher-text2 {
        color: #63bbff;
        font-size: 15px;
        display: inline-block;
        -webkit-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .switcher-text2.inline-text {
        margin-left: 3px;
    }

    .switcher-text2:hover {
        color: #000000;
    }

    .fxt-style-line {
        overflow: hidden;
        text-align: center;
    }

    .fxt-style-line h2 {
        text-align: center;
        font-weight: 300;
        margin-bottom: 30px;
        font-size: 20px;
        color: #a4a4a4;
        display: inline-block;
        position: relative;
        padding: 0 25px;
        z-index: 1;
    }

    .fxt-style-line h2:before {
        display: inline-block;
        content: "";
        height: 1px;
        width: 100%;
        background-color: #ebebeb;
        left: 100%;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        position: absolute;
        z-index: 1;
    }

    .fxt-style-line h2:after {
        display: inline-block;
        content: "";
        height: 1px;
        width: 100%;
        background-color: #ebebeb;
        right: 100%;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        position: absolute;
        z-index: 1;
    }

    ul.fxt-socials {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        margin-right: -5px;
        margin-left: -5px;
        margin-bottom: 20px;
    }

    ul.fxt-socials li {
        max-width: 100%;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 33.33333%;
        flex: 0 0 33.33333%;
        padding-left: 5px;
        padding-right: 5px;
        margin-bottom: 10px;
    }

    @media only screen and (max-width: 575px) {
        ul.fxt-socials li {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }
    }

    @media only screen and (max-width: 350px) {
        ul.fxt-socials li {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
        }
    }

    ul.fxt-socials li a {
        border-radius: 2px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: flex-start;
        -ms-flex-pack: flex-start;
        justify-content: flex-start;
        font-size: 14px;
        height: 45px;
        color: #ffffff;
        -webkit-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    ul.fxt-socials li a i {
        border-radius: 2px 0 0 2px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 45px;
        height: 45px;
    }

    ul.fxt-socials li a span {
        height: 100%;
        width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
    }

    ul.fxt-socials li.fxt-facebook a {
        background-color: #3b5998;
    }

    ul.fxt-socials li.fxt-facebook a i {
        background-color: #4867aa;
    }

    ul.fxt-socials li.fxt-facebook a:hover {
        background-color: #5676bb;
    }

    ul.fxt-socials li.fxt-twitter a {
        background-color: #00acee;
    }

    ul.fxt-socials li.fxt-twitter a i {
        background-color: #33ccff;
    }

    ul.fxt-socials li.fxt-twitter a:hover {
        background-color: #3dc5f3;
    }

    ul.fxt-socials li.fxt-google a {
        background-color: #CC3333;
    }

    ul.fxt-socials li.fxt-google a i {
        background-color: #db4437;
    }

    ul.fxt-socials li.fxt-google a:hover {
        background-color: #e75042;
    }

    .checkbox {
        padding-left: 5px;
        margin-right: 30px;
        margin-bottom: 5px;
    }

    .checkbox label {
        padding-left: 20px;
        color: #a4a4a4;
        margin-bottom: 0;
        font-size: 15px;
        position: relative;
    }

    .checkbox label:before {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 4px;
        left: 0;
        margin-left: -5px;
        border: 1px solid;
        border-color: #dcdcdc;
        border-radius: 3px;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
    }

    .checkbox label:after {
        position: absolute;
        margin-left: -20px;
        padding-left: 3px;
        font-size: 10px;
        color: #555555;
    }

    .checkbox input[type="checkbox"] {
        display: none;
    }

    .checkbox input[type="checkbox"]:checked+label::after {
        font-family: 'Font Awesome 5 Free';
        content: "\f00c";
        font-weight: 900;
        color: #ffffff;
        left: 15px;
        top: 4px;
    }

    .checkbox input[type="checkbox"]:checked+label::before {
        background-color: #ff0000;
        border-color: #ff0000;
    }

    .fxt-footer {
        text-align: center;
    }

    .fxt-footer p {
        color: #999898;
        margin-bottom: 10px;
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .fxt-footer .fxt-btn-resend {
        margin-left: 3px;
        box-shadow: none;
        border: 0;
        background-color: transparent;
        cursor: pointer;
        padding: 0;
        color: #63bbff;
        text-decoration: underline;
        transition: all 0.3s ease-in-out;
    }

    .fxt-footer .fxt-btn-resend:focus {
        outline: none;
    }

    .fxt-footer .fxt-btn-resend:hover {
        color: #000000;
    }

    .fxt-footer .text-or {
        margin-left: 3px;
        color: #000000;
    }






    /* =================================== */
    /*  6. Extras
/* =================================== */
    /* 6.1 Form */
    .form-control {
        border-color: #dae1e3;
        box-shadow: inset 0 0;
    }

    .form-check-input:not(:checked) {
        border-color: #dae1e3;
    }

    .form-control.bg-light {
        background-color: #f5f5f6 !important;
    }

    .form-control.border-light {
        border-color: #f5f5f6 !important;
    }

    .form-control:not(.form-control-sm) {
        padding: .810rem .96rem;
        height: inherit;
    }

    .form-control-sm {
        font-size: 14px;
    }

    .icon-group {
        position: relative;
        width: 100%;
    }

    .icon-group .form-control {
        padding-left: 44px;
    }

    .icon-group .icon-inside {
        position: absolute;
        width: 50px;
        height: 54px;
        left: 0;
        top: 0;
        pointer-events: none;
        font-size: 18px;
        font-size: 1.125rem;
        color: #c4c3c3;
        z-index: 3;
        display: flex;
        -ms-flex-align: center !important;
        align-items: center !important;
        -ms-flex-pack: center !important;
        justify-content: center !important;
    }

    .icon-group.icon-group-end .form-control {
        padding-right: 44px;
        padding-left: 0.96rem;
    }

    .icon-group.icon-group-end .icon-inside {
        left: auto;
        right: 0;
    }

    .form-control-sm+.icon-inside {
        font-size: 0.875rem !important;
        font-size: 14px;
        top: calc(50% - 13px);
    }

    select.form-control:not([size]):not([multiple]):not(.form-control-sm) {
        height: auto;
        padding-top: .700rem;
        padding-bottom: .700rem;
    }

    .form-control:focus {
        -webkit-box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        border-color: #80bdff !important;
    }

    .form-control:focus[readonly] {
        box-shadow: none;
    }

    .input-group-text {
        border-color: #dae1e3;
        background-color: #f1f5f6;
        color: #656565;
    }

    .form-control::-webkit-input-placeholder {
        color: #b1b4b6;
    }

    .form-control:-moz-placeholder {
        /* FF 4-18 */
        color: #b1b4b6;
    }

    .form-control::-moz-placeholder {
        /* FF 19+ */
        color: #b1b4b6;
    }

    .form-control:-ms-input-placeholder,
    .form-control::-ms-input-placeholder {
        /* IE 10+ */
        color: #b1b4b6;
    }

    /* 6.2 Form Dark */
    .form-dark .form-control {
        border-color: #232a31;
        background: #232a31;
        color: #fff;
    }

    .form-dark .form-control:focus {
        border-color: #80bdff !important;
    }

    .form-dark .form-control::-webkit-input-placeholder {
        color: #777b7f;
    }

    .form-dark .form-control:-moz-placeholder {
        /* FF 4-18 */
        color: #777b7f;
    }

    .form-dark .form-control::-moz-placeholder {
        /* FF 19+ */
        color: #777b7f;
    }

    .form-dark .form-control:-ms-input-placeholder,
    .form-dark .form-control::-ms-input-placeholder {
        /* IE 10+ */
        color: #777b7f;
    }

    .form-dark .icon-group .icon-inside {
        color: #777b7f;
    }

    .form-dark .form-check-input:not(:checked) {
        background-color: #232a31;
        border-color: #232a31;
    }

    /* 6.3 Form Border (Input with only bottom border)  */
    .form-border .form-control {
        background-color: transparent;
        border: none;
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 0px;
        padding-left: 0px !important;
        color: black;
    }

    .form-border .form-control::-webkit-input-placeholder {
        color: rgba(0, 0, 0, 0.4);
    }

    .form-border .form-control:-moz-placeholder {
        /* FF 4-18 */
        color: rgba(0, 0, 0, 0.4);
    }

    .form-border .form-control::-moz-placeholder {
        /* FF 19+ */
        color: rgba(0, 0, 0, 0.4);
    }

    .form-border .form-control:-ms-input-placeholder,
    .form-border .form-control::-ms-input-placeholder {
        /* IE 10+ */
        color: rgba(0, 0, 0, 0.4);
    }

    .form-border .form-control:focus {
        box-shadow: none;
        -webkit-box-shadow: none;
        border-bottom-color: rgba(0, 0, 0, 0.7);
    }

    .form-border .form-control:focus.border-dark {
        border-color: var(--bs-themecolor) !important;
    }

    .form-border .form-control:not(output):-moz-ui-invalid:not(:focus),
    .form-border .form-control:not(output):-moz-ui-invalid:-moz-focusring:not(:focus) {
        border-bottom-color: #e10203;
        box-shadow: none;
        -webkit-box-shadow: none;
    }

    .form-border .form-control:not(output):-moz-ui-invalid:not(:focus).border-dark,
    .form-border .form-control:not(output):-moz-ui-invalid:-moz-focusring:not(:focus).border-dark {
        border-color: #e10203 !important;
    }

    .form-border select option {
        color: #666;
    }

    .form-border .icon-group .form-control {
        padding-left: 30px !important;
    }

    .form-border .icon-group .icon-inside {
        color: rgba(0, 0, 0, 0.25);
        width: 30px;
        height: 52px;
        display: flex;
        -ms-flex-align: center !important;
        align-items: center !important;
        -ms-flex-pack: start !important;
        justify-content: start !important;
    }

    .form-border .icon-group.icon-group-end .form-control {
        padding-right: 30px !important;
        padding-left: 0 !important;
    }

    .form-border .icon-group.icon-group-end .icon-inside {
        left: auto;
        right: 0;
        -ms-flex-pack: end !important;
        justify-content: end !important;
    }

    /* 6.4 Form Border Light (Input with only bottom border)  */
    .form-border-light .form-control {
        border-bottom: 1px solid rgba(250, 250, 250, 0.3);
        color: #fafafa;
    }

    .form-border-light .form-control::-webkit-input-placeholder {
        color: rgba(250, 250, 250, 0.7);
    }

    .form-border-light .form-control:-moz-placeholder {
        /* FF 4-18 */
        color: rgba(250, 250, 250, 0.7);
    }

    .form-border-light .form-control::-moz-placeholder {
        /* FF 19+ */
        color: rgba(250, 250, 250, 0.7);
    }

    .form-border-light .form-control:-ms-input-placeholder,
    .form-border-light .form-control::-ms-input-placeholder {
        /* IE 10+ */
        color: rgba(250, 250, 250, 0.7);
    }

    .form-border-light .form-control:focus {
        border-bottom-color: rgba(250, 250, 250, 0.8);
    }

    .form-border-light .form-control:focus.border-light {
        border-color: var(--bs-themecolor) !important;
    }

    .form-border-light .icon-group .icon-inside {
        color: #777b7f;
    }

    .form-border-light select option {
        color: #333;
    }

    /* 6.5 Vertical Multilple input group */
    .vertical-input-group .input-group:first-child {
        padding-bottom: 0;
    }

    .vertical-input-group .input-group:first-child * {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .vertical-input-group .input-group:last-child {
        padding-top: 0;
    }

    .vertical-input-group .input-group:last-child * {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .vertical-input-group .input-group:not(:last-child):not(:first-child) {
        padding-top: 0;
        padding-bottom: 0;
    }

    .vertical-input-group .input-group:not(:last-child):not(:first-child) * {
        border-radius: 0;
    }

    .vertical-input-group .input-group:not(:first-child) * {
        border-top: 0;
    }

    /* 6.6 Other Bootstrap Specific */
    .btn {
        /* padding: 0.8rem 2.6rem; */
        font-weight: 500;
        -webkit-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    /* .btn-sm {
    padding: 0.5rem 1rem;
} */

    .btn:not(.btn-link) {
        -webkit-box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
    }

    .btn:not(.btn-link):hover {
        -webkit-box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        -webkit-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    .input-group-append .btn,
    .input-group-prepend .btn {
        -webkit-box-shadow: none;
        box-shadow: none;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .input-group-append .btn:hover,
    .input-group-prepend .btn:hover {
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    @media (max-width: 575.98px) {
        /* .btn:not(.btn-sm) {
        padding: .810rem 2rem;
    } */

        .input-group>.input-group-append>.btn,
        .input-group>.input-group-prepend>.btn {
            padding: 0 0.75rem;
        }
    }

    .btn-primary {
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bs-themecolor);
        --bs-btn-border-color: var(--bs-themecolor);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: var(--bs-themehovercolor);
        --bs-btn-hover-border-color: var(--bs-themehovercolor);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: var(--bs-themehovercolor);
        --bs-btn-active-border-color: var(--bs-themehovercolor);
    }

    .btn-outline-primary {
        --bs-btn-color: var(--bs-themecolor);
        --bs-btn-border-color: var(--bs-themecolor);
        --bs-btn-hover-bg: var(--bs-themecolor);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-border-color: var(--bs-themecolor);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: var(--bs-themehovercolor);
        --bs-btn-active-border-color: var(--bs-themehovercolor);
    }

    .progress,
    .progress-stacked {
        --bs-progress-bar-bg: var(--bs-themecolor);
    }

    .pagination {
        --bs-pagination-active-bg: var(--bs-themecolor);
        --bs-pagination-active-border-color: var(--bs-themecolor);
    }

    /* styles-switcher */
    #styles-switcher {
        background: #fff;
        width: 202px;
        position: fixed;
        top: 35%;
        z-index: 1051;
        padding: 20px;
        left: -202px;
    }

    #styles-switcher ul {
        padding: 0;
    }

    #styles-switcher ul li {
        list-style-type: none;
        width: 24px;
        height: 24px;
        line-height: 24px;
        margin: 4px 2px;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        text-align: center;
        color: #fff;
        transition: all .2s ease-in-out;
    }

    #styles-switcher ul li.blue {
        background: #007bff;
    }

    #styles-switcher ul li.brown {
        background: #795548;
    }

    #styles-switcher ul li.purple {
        background: #6f42c1;
    }

    #styles-switcher ul li.indigo {
        background: #6610f2;
    }

    #styles-switcher ul li.red {
        background: #dc3545;
    }

    #styles-switcher ul li.orange {
        background: #fd7e14;
    }

    #styles-switcher ul li.yellow {
        background: #ffc107;
    }

    #styles-switcher ul li.green {
        background: #28a745;
    }

    #styles-switcher ul li.teal {
        background: #20c997;
    }

    #styles-switcher ul li.pink {
        background: #e83e8c;
    }

    #styles-switcher ul li.cyan {
        background: #17a2b8;
    }

    #styles-switcher ul li.active {
        transform: scale(0.7);
        cursor: default;
    }

    #styles-switcher .switcher-toggle {
        position: absolute;
        background: #555;
        color: #fff;
        font-size: 1.25rem;
        border-radius: 0px 4px 4px 0;
        right: -40px;
        top: 0;
        width: 40px;
        height: 40px;
        padding: 0;
    }

    #styles-switcher .switcher-toggle:focus {
        box-shadow: none;
    }

    #styles-switcher #reset-color {
        background: #007bff;
    }

    input:-internal-autofill-selected {
        background-color: transparent;
    }

    #styles-switcher.right {
        left: auto;
        right: -202px;
    }

    #styles-switcher.right .switcher-toggle {
        right: auto;
        left: -40px;
        border-radius: 4px 0px 0px 4px;
    }

    /* login form start */
    /* =================================== */
    /*  6. Extras
/* =================================== */
    /* 6.1 Form */
    .form-control {
        border-color: #dae1e3;
        box-shadow: inset 0 0;
    }

    .form-check-input:not(:checked) {
        border-color: #dae1e3;
    }

    .form-control.bg-light {
        background-color: #f5f5f6 !important;
    }

    .form-control.border-light {
        border-color: #f5f5f6 !important;
    }

    .form-control:not(.form-control-sm) {
        padding: .810rem .96rem;
        height: inherit;
    }

    .form-control-sm {
        font-size: 14px;
    }

    .icon-group {
        position: relative;
    }

    .icon-group .form-control {
        padding-left: 64px !important;
    }

    .icon-group .icon-inside {
        position: absolute;
        width: 50px;
        height: 30px;
        margin-top: 8px;
        left: 0;
        top: 0;
        pointer-events: none;
        font-size: 18px;
        font-size: 1.125rem;
        color: #c4c3c3;
        z-index: 3;
        display: flex;
        -ms-flex-align: center !important;
        align-items: center !important;
        -ms-flex-pack: center !important;
        justify-content: center !important;
    }

    .icon-group.icon-group-end .form-control {
        padding-right: 44px;
        padding-left: 0.96rem;
    }

    .icon-group.icon-group-end .icon-inside {
        left: auto;
        right: 0;
    }

    .form-control-sm+.icon-inside {
        font-size: 0.875rem !important;
        font-size: 14px;
        top: calc(50% - 13px);
    }

    .icon-inside {
        border-right: 1px solid #002f345c;
    }

    .f-size-10 {
        font-size: 13px;
        color: #002f34a3;
        padding: 0px 20px;
    }

    /* login form end */

    .fs-9 {
        font-size: 18px;
        font-weight: 600;
        color: #000 !important;
    }

    .welcome-f-title {
        font-size: 30px !important;
    }

    @media only screen and (max-width: 767px) {
        .fxt-logo {
            max-width: 45vw;
        }

        .fxt-btn-fill {
            font-size: 13px;
            padding: 10px;
            white-space: nowrap;
        }

        .mb-5 {
            margin-bottom: 0rem !important;
        }
    }

    .div-alert-mssg {
        font-weight: 600;
        padding: 0px 16px;
    }

    /* @media screen { */
    /* .fxt-header {
        margin-left: -100px;
    }
} */

    /* background image for desktop & phone view start */

    @media only screen and (min-width: 991px) {

        .fxt-template-animation {
            width: 100% !important;
            height: 80vh !important;
            background-image: url('frontend_assets/img-icon/pc_wp.png');
            background-size: 100% 100% !important;
            /* background-position: center !important; */
            background-repeat: no-repeat !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            /* overflow: hidden; */
            object-fit: fill !important;
        }

        .fxt-content {
            /* padding: 60px 65px 60px 65px; */
            width: 100%;
            -webkit-box-shadow: none;
            box-shadow: none;
            background-color: transparent !important;
        }

        .fxt-bg-color {
            background-color: transparent !important;
        }

        .fxt-form {
            margin-top: 135px;
        }

        .col-lg-6 {
            flex: 0 0 auto;
            width: 40% !important;
        }

        .welcome {
            margin-top: 100px !important;
        }

        .fxt-content {
            margin-bottom: -40%;
        }

        .mb-5 {
            margin-bottom: 0rem !important;
        }

        .sidebar-sticky .sidebar-widget .store-info-item .title,
        label {
            margin-bottom: 0px !important;
        }

        .desk-bp,
        .desk-sp {
            white-space: nowrap;
        }

        .row {
            justify-content: center !important;
        }
    }


    @media only screen and (max-width: 767px) {

        .fxt-template-animation {
            width: 100% !important;
            height: 100vh !important;
            background-image: url('frontend_assets/img-icon/logo.jpg');
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            /* overflow: hidden; */
        }

        .fxt-template-animation {
            padding-top: 15px;
            background-size: contain !important;
        }

        .fxt-bg-color {
            background-color: transparent !important;
        }

        .fxt-content {
            background-color: transparent !important;
        }

        .fxt-header {
            background-color: transparent !important;
        }
    }

    /* background image for desktop & phone view end */

    /* checkbox alignment starts */
    /* desktop view */
    .mb-3.d-flex {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    .me-2 {
        margin-right: 0.5rem;
    }

    /* mobile view */
    @media (max-width: 768px) {
        .mb-3.d-flex {
            font-size: 14px;
        }

        .mb-3.d-flex input[type="checkbox"] {
            margin-top: -10px;
        }
    }

    /* checkbox alignment ends */
    .icheck_input {
        display: flex;
        align-items: center;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .icheck_input .input-group {
        background: #db94ff;
        justify-content: center;
        padding: 8px 19px;
        border-radius: 26px;
        width: max-content;
        margin-bottom: 10px;
    }

    .icheck_input label {
        cursor: pointer;
        font-weight: 600;
        margin-bottom: 0px !important;
    }

    .icheck-label-span {
        color: #1e00ff;
        display: none;
    }
</style>

<link href="frontend_assets/assets/global/plugins/icheck/skins/all.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />