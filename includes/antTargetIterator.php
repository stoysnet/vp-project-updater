<?

function antTargetIterator($fn) {
	$dom = new DOMDocument();
	$dom->load($fn);
	foreach ($dom->getElementsByTagName('target') as $target) {
		yield strval($target->getAttribute('name')) => strval($target->getAttribute('description'));
	}
	unset($dom);
	return;
}

function antGetButtons($fn) {
	$dom = new DOMDocument();
	$dom->load($fn);
	$buttons = [];
	foreach ($dom->getElementsByTagName('property') as $prop) {
		if ($prop->getAttribute('name') === 'buttons') {
			foreach (explode(',', $prop->getAttribute('value')) as $btn) {
				$buttons[$btn] = true;
			}
		}
	}
	
	foreach ($dom->getElementsByTagName('property') as $prop) {
		if (!empty($buttons[$prop->getAttribute('name')])) {
			yield $prop->getAttribute('value') => $prop->getAttribute('location');
			unset ($buttons[$prop->getAttribute('name')]);
		}
	}
	
	if (count($buttons) > 0) {
		throw new UnexpectedValueException(
			'Missing buttons: ' . implode(' ', array_keys($buttons))
		);
	}
	
	unset($dom);
	return;
}
