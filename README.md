# jocodehighligth 1.0.1

## Quick Start

Download <a href="https://github.com/JLTRY/jocodehighlight/releases/latest" target="_blank">latest version</a> of package

## Requirements

Joomla 5.0+ 

## Features
See https://joomla.jltryoen.fr/extensions-joomla/plugins/coloration-syntaxique/103-jos-code-highlighter

The zip file includes a plugin
- content/jocodehighlight : a plugin to be able to highligtht code in an article
JO's Code Highlighter is a plugin for Joomla which makes it possible to dress the code with a syntactic coloring.

The Syntactic coloring is a feature of the Text editors and IDE which applies colors and formats to distinguish code elements, thus improving the readability and facilitating the identification of errors


## Example

```
<pre xml:lang="javascript" lines="true" > 
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-19694431-1']);
_gaq.push(['_trackPageview']);
 
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</pre>
```

## 2025-11-17 version 1.0.1

Add tag for including src files
{syntaxhighlight}<file src name>{/syntaxhighlight}

## 2025-10-9 version 1.0.0

Initial version
