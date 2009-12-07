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
	protected function get()
	{
		$wines = array();
		$wines[] = new Wine("Château Margaux", "Margaux", "Red");
		$wines[] = new Wine("Château Petrus", "Pomerol", "Red");
		$wines[] = new Wine("Domaine de la Romanée Conti", "Romanée Conti", "Red");
		
		$representation = null;
		switch ($this->_request->getFormat()) {
			case Formats::XML:
				$content = "<wines>\n";
				foreach ($wines as $wine) {
					$content .= "	<wine>\n" .
						"		<name>" . $wine->getName() . "</name>\n" .
						"		<area>" . $wine->getArea() . "</area>\n" .
						"		<color>" . $wine->getColor() . "</color>\n" .
						"	</wine>\n";
				}
				$content .= "</wines>\n";
				$representation = new StringRepresentation($content);
				break;
			case Formats::JSON:
				$representation = new JsonRepresentation($wines);
				break;
			default:
				$content =
					"<html>\n" .
					"<body>\n" .
					"	<h1>Liste des vins</h1>\n" .
					"	<ul>\n";
				foreach ($wines as $wine) {
					$content .= "		<li>" . $wine->getName() .
								" (" . $wine->getArea() . " - " .
								$wine->getColor() . ")</li>\n";
				}
				$content .= "	</ul>\n" .
					"</body>\n" .
					"</html>\n";
				$representation = new StringRepresentation($content);
				break;
		}
		return $representation;
	}
}
