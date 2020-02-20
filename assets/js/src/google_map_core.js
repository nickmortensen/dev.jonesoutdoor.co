/*same as google_maps.js only a couple of the longer variables are split off and then load as dependencies */
/**
* File google_maps/google_maps.js
*
* Handles the display of the billboard locations map on frontpage.
*/
/*
* Copyright 2017 Google Inc. All rights reserved.
*
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
* file except in compliance with the License. You may obtain a copy of the License at
*
*     http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software distributed under
* the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
* ANY KIND, either express or implied. See the License for the specific language governing
* permissions and limitations under the License.
*/

/* eslint-disable no-undef, no-unused-vars */
const boards = allBillboards;

const hasMultipleFaces = item => {
	if ( item.hasOwnProperty( 'length' ) ) {
		return true;
	}
};
const isASingleFace = item => {
	if ( ! item.hasOwnProperty( 'length' ) ) {
		return true;
	}
};
const singles = boards.filter( isASingleFace );
const multiples = boards.filter( hasMultipleFaces );

// Instantiate the following variables.
let map;
const markers = []; // Instantiate the markers array -- will be pushing data objects into this array when I iterate through the 'billboards' array.
// log the data received via the wp_localize_script function to the console.
// console.table( mapData );

/**0;01;19;12
 * Get the content for the popup window.
 * @param {Array} billboard In this case, a single billboard from the billboards array.
 * @param {Array} mapData Array of data that comes via the wp_localize_script call.
 * @return {string} HTML content for the popup.
 */
const getPopupContent = ( billboard, mapData ) => {
	const category       = billboard.category;
	const title          = billboard.id;
	const description    = billboard.description;
	const type           = billboard.media; // Digital Bulletin, Bulletin, Junior Bulletin, Superscape,
	const media          = billboard.media;
	const coordinates    = billboard.coordinates;
	const totalFaces     = billboard.faces; // Array of objects representing each face of a given billboard. Some have several faces because the billboard is a stacked billboard or a trivision.
	// const typeDefinition = getTypeDefinition( type );

	// Just the streetview image.
	let content = getStreetView( coordinates, mapData ); // Streetview Image.
	content += `
		<div class="flex flex-col items-start">
		<div class="w-full justify-around items-baseline text-xl flex flex-row"><span class="w-1/3 font-bold">Identifier</span><span class="w-2/3">${title}</span></div>
		<div class="w-full justify-around items-baseline text-xl flex flex-row"><span class="w-1/3 font-bold">Description</span><span class="w-2/3">${description}</span></div>
		<div class="w-full justify-around items-baseline text-xl flex flex-row"><span class="w-1/3 font-bold">Category</span><span class="w-2/3">${category}</span></div>
		<div class="w-full justify-around items-baseline text-xl flex flex-row"><span class="w-1/3 font-bold">Qty Faces</span><span class="w-2/3">${totalFaces}</span></div>

		<div class="w-full flex flex-no-wrap justify-end">
			<a class="inner-popup material-icons text-4xl pr-1" title="click to send a message" data-tooltip="click to send a message"> mail_outline </a>
			<a class="inner-popup material-icons text-4xl pr-1" title="click to favorite billboard" data-tooltip="click to save billboard"> favorite_border </a>
		</div>

		</div>
		`;
	return content;
};

// Iterate through the billboards array. Push the coordinates of each billboard into the markers array.
billboards.forEach( billboard => {
	markers.push( billboard.coordinates );
});

const replaceThisDivWithAMap = document.getElementById( 'map' ); // ID of the element within the HTML where we will place the google map.
const centerCoordinates      = mapData.center;

// This is where we INITIALIZE THE MAP and add markers to it as well as the content of the marker div that pops up when the marker is clicked.
function initMap() {
	/**
	 *  Create an instance of the map object.
	 *  Include the element within the HTML that will hold the map and an object with options for a given map.
	 * NOTE: Center is stevens point - because it is more or less the center of Wisconsin;
	 */
	map = new google.maps.Map( document.getElementById( 'map-container' ), {
		zoom: 8,
		center: centerCoordinates,
		styles: mapStyle,
		mapTypeControl: true,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
			position: google.maps.ControlPosition.LEFT_CENTER,
		},
		zoomControl: true,
		zoomControlOptions: { position: google.maps.ControlPosition.LEFT_CENTER },
		scaleControl: true,
		streetViewControl: true,
		streetViewControlOptions: { position: google.maps.ControlPosition.LEFT_CENTER },
		fullscreenControl: true,
	}); // end map declaration.

	/**
	 * The popup window when we click upon a marker.
	 *
	 * We want to setup the instance of the InfoWindow Object outside of any loop, this way only one infoWindowcan be open at a time.
	 */
	const billboardDetailsPopup = new google.maps.InfoWindow({
		maxWidth: 900,
		pixelOffset: new google.maps.Size( -4, -6 ),
	});

	/**
	 * Iterate through the billboard array.
	 * Pull out the relevant data to be shown in each billboardDetailsPopup when a marker is clicked.
	 */
	billboards.map( billboard => {
		const coordinates = billboard.coordinates;
		const content     = getPopupContent( billboard, mapData );

		// Icon is based on what type of billboard 'category' the billboard is in.
		const iconObject = {
			url: `${mapData.iconDir}${billboard.category.toLowerCase()}.png`,
			scaledSize: new google.maps.Size( 64, 64 ),
		};

		const marker = new google.maps.Marker({
			map,
			title: `type: ${billboard.category} id: ${billboard.id}`,
			position: { lat: coordinates.lat, lng: coordinates.lng },
			// icon: iconObject,
			icon: {
				url: `${mapData.iconDir}${billboard.category.toLowerCase()}.png`,
				scaledSize: new google.maps.Size( 64, 64 ),
			},
			animation: google.maps.Animation.Bounce,
			// animation: google.maps.Animation.DROP,
		});

		// Listen for a marker to be clicked. When that happens, show the content in a popup.
		marker.addListener( 'click', function() {
			billboardDetailsPopup.close();
			billboardDetailsPopup.setContent( content );
			billboardDetailsPopup.open( map, marker );
		});
	}); // end event listener for clicks on marker icons.
} // end initMap()
