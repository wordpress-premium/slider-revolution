<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if (!defined('ABSPATH')) exit();

class RevSliderSvgSubject
{
	/**
	 * @var DOMElement
	 */
	protected $element;

	/**
	 * @var RevSliderSvgSubject[]
	 */
	protected $use = [];

	/**
	 * @var RevSliderSvgSubject[]
	 */
	protected $usedIn = [];

	/**
	 * @var int
	 */
	protected $nestingLimit;

	/**
	 * @param DOMElement $element
	 * @param int $limit
	 */
	public function __construct($element, $limit)
	{
		$this->element = $element;
		$this->nestingLimit = $limit;
	}

	/**
	 * @return DOMElement
	 */
	public function getElement()
	{
		return $this->element;
	}

	/**
	 * @return string
	 */
	public function getElementId()
	{
		return $this->element->getAttribute('id');
	}

	/**
	 * @param array $subjects  Previously processed subjects
	 * @param int $level  The current level of nesting.
	 * @return DOMElement|bool
	 */
	public function hasInfiniteLoop(array $subjects = [], $level = 1)
	{
		if ($level > $this->nestingLimit) {
			return $this->getElement();
		}

		if (in_array($this, $subjects, true)) return true;
		
		$subjects[] = $this;
		foreach ($this->use as $subjectUse) {
			$result = $subjectUse['subject']->hasInfiniteLoop($subjects, $level + 1);
			if ($result instanceof DOMElement) return $result;
			if ($result) return true;
		}
		
		return false;
	}

	/**
	 * @param RevSliderSvgSubject $subject
	 * @param string $arrName
	 */
	protected function doAdd($subject, $arrName)
	{
		if ($subject === $this) {
			throw new LogicException('Cannot add self usage');
		}

		$id = $subject->getElementId();
		if (isset($this->$arrName[$id])) {
			$this->$arrName[$id]['count']++;
			return;
		}

		$this->$arrName[$id] = [
			'subject' => $subject,
			'count' => 1,
		];
	}

	/**
	 * @param RevSliderSvgSubject $subject
	 */
	public function addUse($subject)
	{
		$this->doAdd($subject, 'use');
	}

	/**
	 * @param RevSliderSvgSubject $subject
	 */
	public function addUsedIn($subject)
	{
		$this->doAdd($subject, 'usedIn');
	}

	/**
	 * @param string $arrName
	 * @param string $countFunc
	 * @return int
	 */
	protected function doCount($arrName, $countFunc)
	{
		$count = 0;
		foreach ($this->$arrName as $subject) {
			$count += $subject['count'] * max(1, $subject['subject']->$countFunc());
		}
		return $count;
	}

	/**
	 * @return int
	 */
	public function countUse()
	{
		return $this->doCount('use', 'countUse');
	}

	/**
	 * @return int
	 */
	public function countUsedIn()
	{
		return $this->doCount('usedIn', 'countUsedIn');
	}

	/**
	 * get all affected DOMElement's
	 *
	 * @return array
	 */
	public function getAffectedElements()
	{
		$elements = array_map(function ($subjectUse) {
			return $subjectUse['subject']->getElement();
		}, $this->use);

		$this->usedIn = [];
		$this->use = [];

		return $elements;
	}
}
