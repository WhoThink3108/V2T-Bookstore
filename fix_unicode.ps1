# Normalize all blade files to NFC
$utf8NoBom = New-Object System.Text.UTF8Encoding($false)
$files = Get-ChildItem -Path "e:\LT_PHP\CK\V2T-Bookstore\resources\views" -Recurse -Filter "*.blade.php"
foreach ($file in $files) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    if (-not $content.IsNormalized([System.Text.NormalizationForm]::FormC)) {
        $normalized = $content.Normalize([System.Text.NormalizationForm]::FormC)
        [System.IO.File]::WriteAllText($file.FullName, $normalized, $utf8NoBom)
        Write-Host "Fixed: $($file.Name)"
    }
}
Write-Host "All done."
