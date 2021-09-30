<?php

interface InterfaceMessenger {
    function send();
    function _setSentFlag();
    function _getSentFlag();
}