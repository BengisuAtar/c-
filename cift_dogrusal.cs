using System;

public class Dugum
{
    public int Veriler;
    public Dugum Sonraki;
    public Dugum Onceki;

    public Dugum(int veriler)
    {
        Veriler = veriler;
        Sonraki = Onceki = this;
    }
}

public class CiftYonluDaireselBagliListe
{
    private Dugum bas;

    // Başa ekleme işlemi
    public void BasaEkle(int veriler)
    {
        Dugum yeniDugum = new Dugum(veriler);
        if (bas == null)
        {
            bas = yeniDugum;
        }
        else
        {
            Dugum son = bas.Onceki;

            yeniDugum.Sonraki = bas;
            bas.Onceki = yeniDugum;

            yeniDugum.Onceki = son;
            son.Sonraki = yeniDugum;

            bas = yeniDugum;
        }
    }

    // Sona ekleme işlemi
    public void SonaEkle(int veriler)
    {
        Dugum yeniDugum = new Dugum(veriler);
        if (bas == null)
        {
            bas = yeniDugum;
        }
        else
        {
            Dugum son = bas.Onceki;

            yeniDugum.Sonraki = bas;
            bas.Onceki = yeniDugum;

            yeniDugum.Onceki = son;
            son.Sonraki = yeniDugum;
        }
    }

    // Araya ekleme işlemi
    public void ArayaEkle(Dugum oncekiDugum, int veriler)
    {
        if (oncekiDugum == null)
        {
            Console.WriteLine("Önceki düğüm boş olamaz.");
            return;
        }
        Dugum yeniDugum = new Dugum(veriler);
        Dugum sonrakiDugum = oncekiDugum.Sonraki;

        yeniDugum.Sonraki = sonrakiDugum;
        oncekiDugum.Sonraki = yeniDugum;
        yeniDugum.Onceki = oncekiDugum;
        sonrakiDugum.Onceki = yeniDugum;
    }

    // Baştan silme işlemi
    public void BastanSil()
    {
        if (bas == null) return;

        if (bas.Sonraki == bas)
        {
            bas = null;
            return;
        }

        Dugum son = bas.Onceki;
        bas = bas.Sonraki;
        bas.Onceki = son;
        son.Sonraki = bas;
    }

    // Sondan silme işlemi
    public void SondanSil()
    {
        if (bas == null) return;

        if (bas.Sonraki == bas)
        {
            bas = null;
            return;
        }

        Dugum son = bas.Onceki;
        Dugum ikinciSon = son.Onceki;

        ikinciSon.Sonraki = bas;
        bas.Onceki = ikinciSon;
    }

    // Aradan silme işlemi
    public void AradanSil(int anahtar)
    {
        if (bas == null) return;

        Dugum mevcut = bas;
        Dugum onceki = null;

        while (true)
        {
            if (mevcut.Veriler == anahtar)
            {
                if (mevcut == bas && mevcut.Sonraki == bas)
                {
                    bas = null;
                    return;
                }

                if (mevcut == bas)
                {
                    onceki = bas.Onceki;
                    bas = bas.Sonraki;
                    onceki.Sonraki = bas;
                    bas.Onceki = onceki;
                }
                else if (mevcut.Sonraki == bas)
                {
                    onceki.Sonraki = bas;
                    bas.Onceki = onceki;
                }
                else
                {
                    Dugum temp = mevcut.Sonraki;
                    onceki.Sonraki = temp;
                    temp.Onceki = onceki;
                }

                break;
            }

            onceki = mevcut;
            mevcut = mevcut.Sonraki;

            if (mevcut == bas) break;
        }
    }

    // Listeyi ekrana yazdırma işlemi
    public void Goruntule()
    {
        if (bas == null) return;

        Dugum temp = bas;
        do
        {
            Console.Write(temp.Veriler + " ");
            temp = temp.Sonraki;
        } while (temp != bas);
        Console.WriteLine();
    }

    // Listeyi tersten yazdırma işlemi
    public void TerstenGoruntule()
    {
        if (bas == null) return;

        Dugum temp = bas.Onceki;
        do
        {
            Console.Write(temp.Veriler + " ");
            temp = temp.Onceki;
        } while (temp != bas.Onceki);
        Console.WriteLine();
    }

    public static void Main(string[] args)
    {
        CiftYonluDaireselBagliListe liste = new CiftYonluDaireselBagliListe();

        liste.BasaEkle(10);
        liste.SonaEkle(20);
        liste.SonaEkle(30);
        liste.SonaEkle(40);

        Console.WriteLine("Orijinal Liste:");
        liste.Goruntule();

        liste.AradanSil(30);

        Console.WriteLine("30 silindikten sonra güncellenmiş liste:");
        liste.Goruntule();

        liste.ArayaEkle(liste.bas.Sonraki, 25);

        Console.WriteLine("20'den sonra 25 eklendikten sonra güncellenmiş liste:");
        liste.Goruntule();

        liste.BastanSil();
        Console.WriteLine("İlk eleman silindikten sonra güncellenmiş liste:");
        liste.Goruntule();

        liste.SondanSil();
        Console.WriteLine("Son eleman silindikten sonra güncellenmiş liste:");
        liste.Goruntule();

        Console.WriteLine("Listeyi tersten yazdırma:");
        liste.TerstenGoruntule();
    }
}