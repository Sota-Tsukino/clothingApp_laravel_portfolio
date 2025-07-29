@props(['url'])
<tr>
  <td class="header">
    <a href="{{ $url }}" style="display: inline-block;">
      @if (trim($slot) === 'Laravel')
        <img src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/logo/FitCloset_logo.png" class="logo" alt="FitCloset"
          style="width: 270px !important">
      @else
        {{ $slot }}
      @endif
    </a>
  </td>
</tr>
