import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';

const accessToken = 'pk.eyJ1Ijoiam9obi0yMDAxIiwiYSI6ImNsdm1yaXRxNDA2NHgyanBlY2oxanFja3gifQ.W_pQHATCMu0KrjHWAHF-CA';
mapboxgl.accessToken = accessToken;

export { mapboxgl, accessToken };
