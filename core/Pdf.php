<?php

namespace Core;

use TCPDF;

class Pdf
{
	private TCPDF $pdf;
	
	public function __construct()
	{
		$this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	}
	
	public function setInfo(string $author, string $title, string $subject, string $keywords): static
	{
		$this->pdf->setCreator(PDF_CREATOR);
		$this->pdf->setAuthor($author);
		$this->pdf->setTitle($title);
		$this->pdf->setSubject($subject);
		$this->pdf->setKeywords($keywords);
		return $this;
	}
	
	public function addPage(): static
	{
		$this->pdf->AddPage();
		return $this;
	}
	
	public function writeHtmlText($html): static
	{
		$this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, ', true');
		return $this;
	}
	
	public function output($file_name)
	{
		$this->pdf->Output($file_name, 'I');
	}
}