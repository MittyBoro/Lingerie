
export default function isVisible(el)
{
	if (typeof el === 'string')
	{
		el = document.querySelector(el)
	}
	
	if (!el)
		return false;
	
	return !!( el.offsetWidth || el.offsetHeight || el.getClientRects().length );
}