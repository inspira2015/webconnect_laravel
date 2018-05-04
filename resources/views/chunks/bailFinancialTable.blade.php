<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Bail Amount </div></td>
    <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Forfeit/Purge</div></td>
    <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Payment</div></td>
    <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">County Fee </div></td>
    <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Balance</div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_receipt_amount }}</div></td>
    <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_forfeit_amount }}</div></td>
    <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_payment_amount }}</div></td>
    <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_city_fee_amount }}</div></td>
    <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $balance }}</div></td>
  </tr>
</table>