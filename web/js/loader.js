/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

!function (w) {
	
	"use strict";
	
	var Loader = {
					"collection" : new Array(),
					"add" : function(func) {
						this.collection.push(func);
					},
					"call" : function() {
						if(this.collection.length > 0)
						{
							for(var i = 0; i < this.collection.length; i++)
							{
								this.collection[i].call();
							}
							
							// clear the collection so the functions doesn't get called twice in some instances
							this.collection = new Array();
						}
					}
			};
			
	w.Loader = Loader;
}(window);
