'use strict';
const e = React.createElement;

import React from 'react';
import TreeComponent from 'tree-creator-bp';

//this is the sample data from the Request
let data = [
    {
        "id": "1.0",
        "title": "id",
        "description": ""
    },
    {
        "id": "2.0",
        "title": "currency_code",
        "description": "A 3 Character code representing the currency of the order. for instance AUD for Australia OR USD for United States"
    },
    {
        "id": "3.0",
        "title": "customer",
        "description": "Information ont he Customer who submitted the order",
        "children": [
            {
                "id": "3.1",
                "title": "customer_id",
                "description": "an integer representing the customers record in the database"
            },
            {
                "id": "3.2",
                "title": "customer_group_id",
                "description": "an integer representing the customers Group if they reside in one. Customer Groups handle the tax differently per group"
            },
            {
                "id": "3.3",
                "title": "taxability_code",
                "description": "a string representing the tax code"
            }
        ]
    },
    {
        "id": "4.0",
        "title": "transaction_date",
        "description": "a date time object",
        "children": [
            {
                "id": "4.1",
                "title": "date",
                "description": "a string representing the time, for instance 2018-10-24 00:00:00.905536"
            },
            {
                "id": "4.2",
                "title": "timezone_tyoe",
                "description": "an integer representing a timezone type"
            },
            {
                "id": "4.3",
                "title": "timezone",
                "description": "a character string representing the timezone of the date"
            }
        ]
    },
    {
        "id": "5.1",
        "title": "documents",
        "description": "tax document objects for submission, each document contains stuff",
        "children": [
            {
                "id": "5.1.1",
                "title": "id",
                "description": "index of the new document"
            },
            {
                "id": "5.1.2",
                "title": "billing_address",
                "description": "The address the invoice will be sent to",
                "children": [
                    {
                        "id": "5.1.2.1",
                        "title": "line1",
                        "description": "Street address line 1"
                    },
                    {
                        "id": "5.1.2.2",
                        "title": "line2",
                        "description": "Street address line 2"
                    },
                    {
                        "id": "5.1.2.3",
                        "title": "city",
                        "description": "The city name"
                    },
                    {
                        "id": "5.1.2.4",
                        "title": "region_name",
                        "description": "The name of the region the address resides in"
                    },
                    {
                        "id": "5.1.2.5",
                        "title": "region_code",
                        "description": "a short 3 character code of the region for the billing address"
                    },
                    {
                        "id": "5.1.2.6",
                        "title": "country_name",
                        "description": "The name of the country the address resides in"
                    },
                    {
                        "id": "5.1.2.7",
                        "title": "country_code",
                        "description": "a short 3 character code of the country for the billing address"
                    },
                    {
                        "id": "5.1.2.8",
                        "title": "postal_code",
                        "description": "the postal code for the city in the billing address"
                    },
                    {
                        "id": "5.1.2.9",
                        "title": "company_name",
                        "description": "The name of hte company being billed"
                    },
                    {
                        "id": "5.1.2.10",
                        "title": "type",
                        "description": " the type of address"
                    }
                ]
            },
            {
                "id": "5.1.3",
                "title": "destination_address",
                "description": "The address the package is being sent to",
                "children": [
                    {
                        "id": "5.1.3.1",
                        "title": "line1",
                        "description": "Street address line 1"
                    },
                    {
                        "id": "5.1.3.2",
                        "title": "line2",
                        "description": "Street address line 2"
                    },
                    {
                        "id": "5.1.3.3",
                        "title": "city",
                        "description": "The city name"
                    },
                    {
                        "id": "5.1.3.4",
                        "title": "region_name",
                        "description": "The name of the region the address resides in"
                    },
                    {
                        "id": "5.1.3.5",
                        "title": "region_code",
                        "description": "a short 3 character code of the region for the destination address"
                    },
                    {
                        "id": "5.1.3.6",
                        "title": "country_name",
                        "description": "The name of the country the address resides in"
                    },
                    {
                        "id": "5.1.3.7",
                        "title": "country_code",
                        "description": "a short 3 character code of the country for the destination address"
                    },
                    {
                        "id": "5.1.3.8",
                        "title": "postal_code",
                        "description": "the postal code for the city in the destination address"
                    },
                    {
                        "id": "5.1.3.9",
                        "title": "company_name",
                        "description": "The name of the company the package will be sent to"
                    },
                    {
                        "id": "5.1.3.10",
                        "title": "type",
                        "description": " the type of address"
                    }
                ]
            },
            {
                "id": "5.1.4",
                "title": "origin_address",
                "description": "The address the package is being sent from",
                "children": [
                    {
                        "id": "5.1.4.1",
                        "title": "line1",
                        "description": "Street address line 1"
                    },
                    {
                        "id": "5.1.4.2",
                        "title": "line2",
                        "description": "Street address line 2"
                    },
                    {
                        "id": "5.1.4.3",
                        "title": "city",
                        "description": "The city name"
                    },
                    {
                        "id": "5.1.4.4",
                        "title": "region_name",
                        "description": "The name of the region the address resides in"
                    },
                    {
                        "id": "5.1.4.5",
                        "title": "region_code",
                        "description": "a short 3 character code of the region for the origin address"
                    },
                    {
                        "id": "5.1.4.6",
                        "title": "country_name",
                        "description": "The name of the country the address resides in"
                    },
                    {
                        "id": "5.1.4.7",
                        "title": "country_code",
                        "description": "a short 3 character code of the country for the origin address"
                    },
                    {
                        "id": "5.1.4.8",
                        "title": "postal_code",
                        "description": "the postal code for the city in the origin address"
                    },
                    {
                        "id": "5.1.4.9",
                        "title": "company_name",
                        "description": "The name of the company the package will be sent from"
                    },
                    {
                        "id": "5.1.4.10",
                        "title": "type",
                        "description": " the type of address"
                    }
                ]
            },
            {
                "id": "5.1.5",
                "title": "shipping",
                "description": "Details of the shipping price",
                "children": [
                    {
                        "id": "5.1.5.1",
                        "title": "id",
                        "description": "index of the shipping element"
                    },
                    {
                        "id": "5.1.5.2",
                        "title": "item_code",
                        "description": "name of the quote"
                    },
                    {
                        "id": "5.1.5.3",
                        "title": "name",
                        "description": "description of the element"
                    },
                    {
                        "id": "5.1.5.4",
                        "title": "price",
                        "description": "name of the quote",
                        "children": [
                            {
                                "id": "5.1.5.4.1",
                                "title": "amount",
                                "description": "float val of price"
                            },
                            {
                                "id": "5.1.5.4.2",
                                "title": "tax_inclusive",
                                "description": "boolean of whether this price should include tax"
                            }
                        ]
                    },
                    {
                        "id": "5.1.5.5",
                        "title": "quantity",
                        "description": "the amount of shipments"
                    },
                    {
                        "id": "5.1.5.6",
                        "title": "tax_class",
                        "description": "object representing tax class",
                        "children": [
                            {
                                "id": "5.1.5.6.1",
                                "title": "code",
                                "description": "short string representing the tax class"
                            },
                            {
                                "id": "5.1.5.6.2",
                                "title": "class_id",
                                "description": "an integer representing the class"
                            },
                            {
                                "id": "5.1.5.4.1",
                                "title": "name",
                                "description": "The name of the tax class"
                            }
                        ]
                    },
                    {
                        "id": "5.1.5.7",
                        "title": "tax_exempt",
                        "description": "boolean of whether this item is exempt from taxation"
                    },
                    {
                        "id": "5.1.5.8",
                        "title": "type",
                        "description": "the type of document element"
                    },
                    {
                        "id": "5.1.5.9",
                        "title": "wrapping",
                        "description": "cost of wrapping"
                    }
                ]
            },
            {
                "id": "5.1.5",
                "title": "handling",
                "description": "Details of the handling price",
                "children": [
                    {
                        "id": "5.1.5.1",
                        "title": "id",
                        "description": "index of the handling element"
                    },
                    {
                        "id": "5.1.5.2",
                        "title": "item_code",
                        "description": "name of the quote"
                    },
                    {
                        "id": "5.1.5.3",
                        "title": "name",
                        "description": "description of the element"
                    },
                    {
                        "id": "5.1.5.4",
                        "title": "price",
                        "description": "name of the quote",
                        "children": [
                            {
                                "id": "5.1.5.4.1",
                                "title": "amount",
                                "description": "float val of price"
                            },
                            {
                                "id": "5.1.5.4.2",
                                "title": "tax_inclusive",
                                "description": "boolean of whether this price should include tax"
                            }
                        ]
                    },
                    {
                        "id": "5.1.5.5",
                        "title": "quantity",
                        "description": "the amount of handling"
                    },
                    {
                        "id": "5.1.5.6",
                        "title": "tax_class",
                        "description": "object representing tax class",
                        "children": [
                            {
                                "id": "5.1.5.6.1",
                                "title": "code",
                                "description": "short string representing the tax class"
                            },
                            {
                                "id": "5.1.5.6.2",
                                "title": "class_id",
                                "description": "an integer representing the class"
                            },
                            {
                                "id": "5.1.5.4.1",
                                "title": "name",
                                "description": "The name of the tax class"
                            }
                        ]
                    },
                    {
                        "id": "5.1.5.7",
                        "title": "tax_exempt",
                        "description": "boolean of whether this item is exempt from taxation"
                    },
                    {
                        "id": "5.1.5.8",
                        "title": "type",
                        "description": "the type of document element"
                    },
                    {
                        "id": "5.1.5.9",
                        "title": "wrapping",
                        "description": "cost of wrapping"
                    }
                ]
            },
            {
                "id": "5.1.6",
                "title": "items",
                "description": "a list of items",
                "children": [
                    {
                        "id": "5.1.5",
                        "title": "handling",
                        "description": "Details of the handling price",
                        "children": [
                            {
                                "id": "5.1.5.1",
                                "title": "id",
                                "description": "index of the handling element"
                            },
                            {
                                "id": "5.1.5.2",
                                "title": "item_code",
                                "description": "name of the quote"
                            },
                            {
                                "id": "5.1.5.3",
                                "title": "name",
                                "description": "description of the element"
                            },
                            {
                                "id": "5.1.5.4",
                                "title": "price",
                                "description": "name of the quote",
                                "children": [
                                    {
                                        "id": "5.1.5.4.1",
                                        "title": "amount",
                                        "description": "float val of price"
                                    },
                                    {
                                        "id": "5.1.5.4.2",
                                        "title": "tax_inclusive",
                                        "description": "boolean of whether this price should include tax"
                                    }
                                ]
                            }

                        ]
                    }
                ]
            }
        ]
    }
];

const componentRoot = document.querySelector('#myContainer');
ReactDOM.render(<TreeComponent data={data}/>, componentRoot);
