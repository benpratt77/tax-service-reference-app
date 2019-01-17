import React from 'react';
import TreeComponent from 'tree-creator-bp';

let data = [];

const componentRoot = document.querySelector('#myContainer');
ReactDOM.render(<TreeComponent data={data}/>, componentRoot);
