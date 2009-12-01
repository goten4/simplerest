<?php

/**
 * Users resource
 * @resource
 * @uri /wines
 * @uri /wines-list
 * @uri /liste-des-vins
 */
class WinesResource extends Resource
{
	protected function get($request)
	{
		switch ($request->getFormat()) {
			case HttpFormats::XML:
				$content =
					"<wines>\n" .
					"	<wine>\n" .
					"		<name>Château Margaux</name>\n" .
					"		<area>Margaux</area>\n" .
					"		<color>Red</color>\n" .
					"	</wine>\n" .
					"	<wine>\n" .
					"		<name>Château Petrus</name>\n" .
					"		<area>Pomerol</area>\n" .
					"		<color>Red</color>\n" .
					"	</wine>\n" .
					"	<wine>\n" .
					"		<name>Domaine de la Romanée Conti</name>\n" .
					"		<area>Romanée Conti</area>\n" .
					"		<color>Red</color>\n" .
					"	</wine>\n" .
					"</wines>\n";
				break;
			case HttpFormats::JSON:
				$content =
					"{ \n" .
					"	{ 'name' => 'Château Margaux',\n" .
					"	  'area' => 'Margaux'\n" .
					"	  'color' => 'Red' },\n" .
					"	{ 'name' => 'Château Petrus',\n" .
					"	  'area' => 'Pomerol'\n" .
					"	  'color' => 'Red' },\n" .
					"	{ 'name' => 'Domaine de la Romanée Conti',\n" .
					"	  'area' => 'Romanée Conti'\n" .
					"	  'color' => 'Red' },\n" .
					"}\n";
				break;
			
			default:
				$content =
					"<html>\n" .
					"<body>\n" .
					"	<h1>Liste des vins</h1>\n" .
					"	<ul>\n" .
					"		<li>Château Margaux (Margaux - rouge)</li>\n" .
					"		<li>Château Petrus (Pomerol - rouge)</li>\n" .
					"		<li>Domaine de la Romanée Conti (Romanée Conti - rouge)</li>\n" .
					"	</ul>\n" .
					"</body>\n" .
					"</html>\n";
				break;
		}
		return new HttpResponse(HttpResponseCodes::HTTP_OK, $content);
	}
}
