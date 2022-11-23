// Radiohead EM
// @ts-check
;(function() {

//#region Variables and Initialization

const APP_NAME = 'Radiohead';

if (typeof window['REDCap'] == 'undefined') {
    window['REDCap'] = {
        EM: {}
    };
}
if (typeof window['REDCap']['EM'] == 'undefined') {
    window['REDCap']['EM'] = {
        RUB: {}
    };
}
if (typeof window['REDCap']['EM']['RUB'] == 'undefined') {
    window['REDCap']['EM']['RUB'] = {};
}
window['REDCap']['EM']['RUB']['Radiohead'] = {
    init: init,
};

let config;

function init(data) {
    config = data;
    log(config);
    $(function() {
        setup();
    });
}

//#endregion

//#region Setup headings

function setup() {

}

//#endregion

//#region Debug Logging
/**
 * Logs a message to the console when in debug mode
 */
function log() {
    if (!config.debug) return;
    let ln = '??';
    try {
        const line = ((new Error).stack ?? '').split('\n')[2];
        const parts = line.split(':');
        ln = parts[parts.length - 2];
    }
    catch { }
    log_print(ln, 'log', arguments);
}
/**
 * Logs a warning to the console when in debug mode
 */
function warn() {
    if (!config.debug) return;
    let ln = '??';
    try {
        const line = ((new Error).stack ?? '').split('\n')[2];
        const parts = line.split(':');
        ln = parts[parts.length - 2];
    }
    catch { }
    log_print(ln, 'warn', arguments);
}
/**
 * Logs an error to the console when in debug mode
 */
function error() {
    let ln = '??';
    try {
        const line = ((new Error).stack ?? '').split('\n')[2];
        const parts = line.split(':');
        ln = parts[parts.length - 2];
    }
    catch { }
    log_print(ln, 'error', arguments);
}
/**
 * Prints to the console
 * @param {string} ln Line number where log was called from
 * @param {'log'|'warn'|'error'} mode 
 * @param {IArguments} args 
 */
function log_print(ln, mode, args) {
    const prompt = APP_NAME + ' [' + ln + ']';
    switch(args.length) {
        case 1: 
            console[mode](prompt, args[0]);
            break;
        case 2: 
            console[mode](prompt, args[0], args[1]);
            break;
        case 3: 
            console[mode](prompt, args[0], args[1], args[2]);
            break;
        case 4: 
            console[mode](prompt, args[0], args[1], args[2], args[3]);
            break;
        case 5: 
            console[mode](prompt, args[0], args[1], args[2], args[3], args[4]);
            break;
        case 6: 
            console[mode](prompt, args[0], args[1], args[2], args[3], args[4], args[5]);
            break;
        default: 
            console[mode](prompt, args);
            break;
    }
}
//#endregion

})();