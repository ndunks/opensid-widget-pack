
let modules = require.context("./blocks/", false, /\.t|jsx?$/);
modules.keys().forEach( modules );
modules = require.context("./widgets/", false, /\.t|jsx?$/);
modules.keys().forEach( modules ) ;
