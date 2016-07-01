var numberOfDropdowns = 0;

var onSelect = function() {
    this.button.setAttribute('style', 'color: #000;');
    this.button.setAttribute('value', this.innerHTML.replace(/\n|<.*?>/g,''));
}

function materialSelect(domElement, name, options, defaultText) {
    var button = document.createElement('input');
    button.id = numberOfDropdowns;
    button.setAttribute('type', 'custom');
    button.setAttribute('name', name);
    button.setAttribute('style', 'cursor: pointer; width: 100%;');
    button.setAttribute('class', 'mdl-select__input mdl-js-button');
    button.setAttribute('value', defaultText.length > 0 ? defaultText : options[0]);
    document.getElementById(domElement).appendChild(button);

    var ul = document.createElement('UL');
    ul.setAttribute('class', 'mdl-menu mdl-js-menu mdl-js-ripple-effect');
    //ul.setAttribute('style', 'width: ' + button.offsetWidth);
    ul.setAttribute('for', numberOfDropdowns);
    for(var index in options) {
        var li = document.createElement('LI');
        li.setAttribute('class', 'mdl-menu__item');
        li.innerHTML = options[index];
        li.button = button;
        li.onclick = onSelect;
        ul.appendChild(li);
    }
    document.getElementById(domElement).appendChild(ul);
    numberOfDropdowns++;
}