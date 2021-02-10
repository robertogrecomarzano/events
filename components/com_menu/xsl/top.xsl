<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" />
	<xsl:template match='menu'>
		<xsl:apply-templates select='node' />
	</xsl:template>
	<xsl:template match='node'>
		<xsl:if test="not(@hide)">
			<xsl:if test="@icon!=''">
				<xsl:variable name="link">
					<xsl:value-of select="@icon" />
				</xsl:variable>
			</xsl:if>
			<xsl:variable name="link-style">
				<xsl:choose>
					<xsl:when test="@icon-style!=''">
						<xsl:value-of select="@icon-style" />
					</xsl:when>
					<xsl:otherwise>
						fas
					</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>
			<xsl:variable name="link">
				<xsl:choose>
					<xsl:when test="@icon!=''">
						<xsl:value-of select="@icon" />
					</xsl:when>
				</xsl:choose>
			</xsl:variable>
			<a class='navbar-brand'>

				<xsl:attribute name='href'>
							<xsl:value-of select="@url" />
					</xsl:attribute>

				<xsl:attribute name='title'><xsl:value-of
					select="label" /></xsl:attribute>

				<i class="{$link-style} fa-{$link} fa-2x">		</i>
			</a>

		</xsl:if>
	</xsl:template>

</xsl:stylesheet>