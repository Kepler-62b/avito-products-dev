<?php
/*
 *  Copyright 2023.  Baks.dev <admin@baks.dev>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

namespace BaksDev\Avito\Products\UseCase\NewEdit\Images;

use BaksDev\Avito\Products\Entity\Images\AvitoProductImagesInterface;
use BaksDev\Avito\Products\Type\Image\AvitoProductImageUid;
use Symfony\Component\HttpFoundation\File\File;

/** @see AvitoProductImage */
final class AvitoProductImagesDTO implements AvitoProductImagesInterface
{
    private ?AvitoProductImageUid $id = null;

    /** Обложка категории */
    public ?File $file = null;

    /** Название файла */
    private ?string $name = null;

    /** Расширение */
    private ?string $ext = null;

    /** Флаг загрузки CDN */
    private bool $cdn = false;

    /** Главное фото */
    private bool $root = false;

    /** Размер файла */
    private ?int $size = null;

    public function getId(): ?AvitoProductImageUid
    {
        return $this->id;
    }

    public function setId(?AvitoProductImageUid $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getExt(): ?string
    {
        return $this->ext;
    }

    public function setExt(?string $ext): self
    {
        $this->ext = $ext;
        return $this;
    }

    public function getCdn(): bool
    {
        return $this->cdn;
    }

    public function getRoot(): bool
    {
        return $this->root;
    }

    public function setRoot(bool $root): void
    {
        $this->root = $root;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }
}
